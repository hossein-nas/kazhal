module.exports = {
    env: {
        browser: true,
        es6: true,
        node: true
    },
    extends: [
        "plugin:vue/essential",
        "prettier/vue",
        "plugin:prettier/recommended",
    ],
    globals: {
        Atomics: "readonly",
        SharedArrayBuffer: "readonly"
    },
    parserOptions: {
        ecmaVersion: 2018,
        sourceType: "module"
    },
    plugins: ["vue"],
    rules: {
        indent: ["error", 4],
        quotes: [2, "double", { avoidEscape: true }],
        "prettier/prettier" : "error",
    }
};
