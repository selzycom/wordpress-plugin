<?php

add_action( 'wp_ajax_wpselzy_subscribe', 'wpselzy_action_callback' );
add_action( 'wp_ajax_nopriv_wpselzy_subscribe', 'wpselzy_action_callback' );

function wpselzy_action_callback() {
	// 1. Нужно знать ID формы, с которой пришли данные - должен отправлять фронт
	// 2. Собираем и валидируем (минимально) данные из формы
	// 3. Получаем АПИ-ключ, создаем объект SelzyApi
	// 4. Отправляем данные в метод subscribe
	// 5. Смотрим ответ, возвращаем ответ на фронт
	$api_key = get_option( 'wpselzy_api_key' );
	if ( ! $api_key ) {
		return;
	}
	$api = new \Selzy\ApiWrapper\SelzyApi( $api_key );

	$formData = json_decode( str_replace( '\"', '"', $_POST['data'] ), true );
	if ( empty( $formData ) ) {
		wpselzy_subscribe_send_error_response( [
			'message' => 'Данные формы не установлены'
		] );
	}
	if ( ! isset( $formData['email'] ) ) {
		wpselzy_subscribe_send_error_response( [
			'message' => 'email не установлен'
		] );
	}
	if ( ! isset( $_POST['contact_list'] ) && intval( $_POST['contact_list'] ) > 0 ) {
		wpselzy_subscribe_send_error_response( [
			'message' => 'contact_list не установлен'
		] );
	}
	$contact_list_id = intval( $_POST['contact_list'] );

	/* Возвращаемое значение
	Объект с единственным полем person_id – целым положительным десятичным 64-битным уникальным кодом контакта.
	Пример возвращаемого значения: {"result":{"person_id":2500767342}} */
	/* Документация метода subscribe: https://www.selzy.com/en/support/api/contacts/subscribe/ */
	$result = $api->subscribe( [
		/* Перечисленные через запятую коды списков, в которые надо добавить контакта. Коды можно узнать с помощью
		метода getLists. Они совпадают с кодами, используемыми в форме подписки. */
		'list_ids'     => $contact_list_id,
		/* Ассоциативный массив дополнительных полей. Массив в запросе передаётся строкой
		вида fields[NAME1]=VALUE1&fields[NAME2]=VALUE2 Обязательно должно присутствовать поле «email»,
		иначе метод возвратит ошибку. В случае наличия и email, и телефона, контакт будет включён и в email,
		и в SMS списки рассылки. Обратите внимание, что значение поля «phone» должно передаваться в
		международном формате (пример: +79261232323). */
		'fields'       => $formData,
		/* 	Принимает значение 0, 3 или 4.
		- Если 0, то мы считаем, что контакт только высказал желание подписаться, но ещё не подтвердил подписку.
		В этом случае контакту будет отправлено письмо-приглашение подписаться. Текст письма будет взят из свойств
		первого списка из list_ids. Кстати, текст можно поменять с помощью метода updateOptInEmail или через веб-интерфейс.
		- Если 3, то также считается, что у Вас согласие контакта уже есть, контакт добавляется со статусом «новый».
		- Если 4, то система выполняет проверку на наличие контакта в ваших списках. Если контакт уже есть в ваших
		списках со статусом «новый» или «активен», то адрес просто будет добавлен в указанный вами список. Если же
		контакт отсутствует в ваших списках или его статус отличен от «новый» или «активен», то ему будет отправлено
		письмо-приглашение подписаться. Текст этого письма можно настроить для каждого списка с помощью метода
		updateOptInEmail или через веб-интерфейс.
		- Если аргумент принимает значение 0 или 4 (и контакта нет в списке), то после подписки через данный метод он
		не сразу попадает в указанный список, а вначале окажется «вне списков» со статусом «запрошено подтверждение».
		Только когда контакт подтвердит подписку, перейдя по ссылке из письма, которое ему было отправлено, он попадает
		в нужный список и получит активный статус. */
		'double_optin' => 3
	] );

	$data = json_decode( $result, true );
	if ( isset( $data['result'] ) && isset( $data['result']['person_id'] ) ) {
		wpselzy_subscribe_send_success_response( [
			'message' => 'Вы успешно подписались'
		] );
	} else {
		wpselzy_subscribe_send_error_response( [
			'message' => 'Selzy error.',
			'detail'  => json_encode( $data )
		] );
	}
}

function wpselzy_subscribe_send_success_response( $data ) {
	wp_send_json( [
		'status' => 'success',
		'data'   => $data,
	] );
}

function wpselzy_subscribe_send_error_response( $data ) {
	wp_send_json( [
		'status' => 'error',
		'data'   => $data,
	] );
}