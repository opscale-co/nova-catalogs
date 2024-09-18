export default {
    "*.php": [
        "vendor/bin/duster lint"
    ],
    "*.vue": [
        "eslint resources/js --fix --ext vue"
    ],
    "*.js": [
        "eslint resources/js --fix --ext js"
    ]
}
