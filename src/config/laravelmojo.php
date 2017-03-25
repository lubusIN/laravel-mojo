<?php

return [

    /*
     * Specify the Private AUTH KEY in your .env file provided
     * by Instamojo in the API & Plugin's section
     * of your account's integration page.
     */
    
    'key' => env('INSTAMOJO_KEY', null),

    /*
     * Specify your Private AUTH TOKEN in your .env file provided by Instamojo in the
     * API & Plugins section of your integration page.
     * Also I haven't watched a single episode of FRIENDS yet, please
     * don't judge me for that. It's on my list.
     */
    
    'token' => env('INSTAMOJO_TOKEN', null),

    /*
     * The URL of your app to which the user will be redirected after the
     * payment process at Instamojo's part will end.
     * Tip : If you are testing on localhost , create a alias in your host
     * with a custom domain for 127.0.0.1 , use that domain/your_project/public
     * as your base URL. And add it to your routes.
     */

    'redirect_url_after_payment' => env('INSTAMOJO_REDIRECT_URL', null),

    /*
     * These took me an hour to figure out , for testing purposers you will
     * most probably use the instamojo sandbox testing account , if thats
     * the case, then the subdomain for all your endpoints will be "test"
     * thats why it has been set as the default , OR if you are
     * using the production verified account,
     * then it will be "www"
     */

    'subdomain_for_endpoints' => env('INSTAMOJO_SUBDOMAIN', null),

    /*
     * WEBHOOK is your app's URL to which Instamojo sends
     * payment details as a POST request. This package
     * handles everything , you just have to define
     * the POST route & add it your route's file
     */
    
    'webhook_url' => env('INSTAMOJO_WEBHOOK_URL', null),

    /*
     * Specify the Private SALT in your .env file provided
     * by Instamojo in the API & Plugin's section
     * of your account's integration page.
     */
    
    'salt' => env('INSTAMOJO_SALT', null),
    
];
