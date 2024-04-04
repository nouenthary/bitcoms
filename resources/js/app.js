import './bootstrap';

import { createApp } from 'vue';
import Home from "./components/Home.vue";
import TradingTransaction from "./components/TradingTransaction.vue";

const app = createApp({});

app.component("TradingTransaction", TradingTransaction);

app.mount("#app");
