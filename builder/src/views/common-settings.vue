<template>
    <div class="b-unisender-app-common-settings b-unisender-app__common-settings">
        <div class="b-unisender-app-common-settings__header">
            <div class="b-unisender-app-common-settings__tab-buttons">
                <div class="b-unisender-app-common-settings__tab-button"
                     v-for="(item, index) in tabs.buttons"
                     :key="`tab-button-${index}`"
                     :class="index === activeTab ? 'active' : ''"
                     @click="handleTabButtonClick(index)"
                >
                    {{item}}
                </div>
            </div>
            <div class="b-unisender-app-common-settings__toggle-button"
                 :class="showContent ? 'active' : ''"
                 @click="tabContentShowButtonHandle">
                <span></span>
            </div>
        </div>
        <div class="b-unisender-app-common-settings__main"
            :class="showContent ? 'active' : ''"
        >
            <div class="b-unisender-app-common-settings__tab-content"
                :class="activeTab === 0 ? 'active' : ''"
            >
                <CommonSettingForm></CommonSettingForm>
            </div>
            <div class="b-unisender-app-common-settings__tab-content"
                :class="activeTab === 1 ? 'active' : ''"
            >
                <CommonSettingMessages></CommonSettingMessages>
            </div>
        </div>
    </div>
</template>

<script>
import CommonSettingForm from '@/components/common-settings-form'
import CommonSettingMessages from '@/components/common-settings-messages'
export default {
    components: {
        CommonSettingForm,
        CommonSettingMessages
    },
    data() {
        return {
            activeTab: 0,
            tabs: {
                buttons: ['Форма', 'Сообщения']
            },
            showContent: true
        }
    },
    methods: {
        handleTabButtonClick(index) {
            this.activeTab = index
        },
        tabContentShowButtonHandle() {
            this.showContent = !this.showContent
        }
    }
}
</script>