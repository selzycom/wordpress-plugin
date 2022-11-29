import Vue from 'vue'
import Vuex from 'vuex'

import accordions from "./accordions";
import types from "./types";
import validation from "./validation";
import styles from "./styles";
import data from "./data";
import commonSettings from "./common-settings";
import stylesData from "./styles-data";
import unisenderAdditionalFields from "./unisender-additional-fields.js";
import tooltips from "./tooltips";

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    accordions,
    types,
    validation,
    styles,
    data,
    commonSettings,
    stylesData,
    unisenderAdditionalFields,
    tooltips
  }
})