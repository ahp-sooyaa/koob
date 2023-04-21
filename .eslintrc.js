module.exports = {
    env: {
        browser: true,
        es2021: true,
        node: true,
    },
    extends: ["eslint:recommended", "plugin:vue/vue3-recommended", "prettier"],
    parserOptions: {
        ecmaVersion: 13,
        sourceType: "module",
    },
    globals: {
        route: true, // adding ziggy route() as global variable otherwise eslint showing as 'no-undef' error
        axios: true,
    },
    // rules: {
    // indent: ["error", 4],
    // "linebreak-style": ["error", "unix"],
    // quotes: ["error", "single", { allowTemplateLiterals: true }],
    // semi: ["error", "never"],
    // "no-undef": "off",
    // "vue/require-prop-types": "off",
    // "vue/attributes-order": [
    //     "error",
    //     {
    //         order: [
    //             "DEFINITION",
    //             "LIST_RENDERING",
    //             "CONDITIONALS",
    //             "RENDER_MODIFIERS",
    //             "GLOBAL",
    //             ["UNIQUE", "SLOT"],
    //             "TWO_WAY_BINDING",
    //             "OTHER_DIRECTIVES",
    //             "EVENTS",
    //             "OTHER_ATTR",
    //             "CONTENT",
    //         ],
    //         alphabetical: false,
    //     },
    // ],
    // "vue/html-indent": ["error", "tab"],
    // },
};
