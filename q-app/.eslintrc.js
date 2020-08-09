module.exports = {
    root: true,

    parserOptions: {
        parser: "babel-eslint",
        sourceType: "module"
    },

    env: {
        browser: true
    },

    extends: [
        // https://eslint.vuejs.org/rules/#priority-a-essential-error-prevention
        // consider switching to `plugin:vue/strongly-recommended` or `plugin:vue/recommended` for stricter rules.
        "plugin:vue/essential",
        "@vue/standard"
        ],

    // required to lint *.vue files
    plugins: ["vue"],

    globals: {
        ga: true, // Google Analytics
        cordova: true,
        __statics: true,
        process: true,
        Capacitor: true,
        chrome: true
    },

    // add your custom rules here
    rules: {
        indent: ["error", 4],
        // allow async-await
        "generator-star-spacing": "off",
        // allow paren-less arrow functions
        "arrow-parens": "off",
        "no-unused-vars" : "off",
        "eqeqeq" : "off",
        "one-var": "off",
        "comma-dangle": ["error", {
            "arrays": "never",
            "objects": "always",
            "imports": "never",
            "exports": "never",
            "functions": "never"
        }],
        "newline-before-return" : "error",
        "function-paren-newline": ["error", { "minItems": 4 }],
        "padding-line-between-statements": [
            "error",
            { "blankLine": "always", "prev": "*", "next": "block-like"},
            { "blankLine": "always", "prev": "block-like", "next": "*"},
        ],
        "import/first": "off",
        "import/named": "error",
        "import/namespace": "error",
        "import/default": "error",
        "import/export": "error",
        "import/extensions": "off",
        "import/no-unresolved": "off",
        "import/no-extraneous-dependencies": "off",
        "prefer-promise-reject-errors": "off",
        "camelcase" : "off",
        "vue/html-indent": ["error", 4, {
            "attribute": 1,
            "baseIndent": 1,
            "closeBracket": 0,
            "alignAttributesVertically": true,
            "ignores": []
        }],
        "vue/max-attributes-per-line": ["error", {
            "singleline": 1,
            "multiline": {
              "max": 1,
              "allowFirstLine": true
          }
      }],

        // allow debugger during development only
        "no-debugger": process.env.NODE_ENV === "production" ? "error" : "off"
    }
};
