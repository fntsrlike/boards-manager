/* Global variable. */
var config      = {};
    models      = {},
    views       = {},
    controllers = {},
    listener    = {},
    events      = {},
    api         = {},
    i18n        = {}, // i18n resource
    lang        = {}; // Target language resource decide by config


/* Required: You should change here with your local environment. */

config.host = 'http://localhost:9527';


/* Options: Some preferences that up to you. */

config.i18n = 'en_US';      // Your target language of i18n resource
config.sweetAlert = true;   // If you want to use sweetAlert to instead of tradtional alert


/* Initailization: Don't modify here. */

api = {
    views    : config.host + '/api/views',
    users    : config.host + '/api/users',
    records  : config.host + '/api/records',
    boards   : config.host + '/api/boards',
    login    : config.host + '/login'
};
