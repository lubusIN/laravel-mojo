<?php

return [

    /* Specify your Private AUTH Token provided by Instamojo in the
     * API & Plugins section of your integration page.
     */
    
    'key' => '',

    /*
     * Specify your Private AUTH Token provided by Instamojo in the 
     * API & Plugins section of your integration page.
     * Also I haven't watched a single episode of Game of thrones yet, please
     * don't judge me for that. It's on my list.
     */
    
    'token' => '', 

    /*
     * The URL of your app to which the user will be redirected after the  
     * payment process at Instamojo's end.
     * Tip : If you are testing on localhost , create a alias in your host
     * with a custom domain for 127.0.0.1 , use that domain/your_project/public
     * as you base URL. And add it to your routes.
     */

    'redirect_url_after_payment' => '',

    /*
     * These took me an hour to figure out , for testing purposers you will  
     * most probably use the instamojo sandbox testing account , if thats
     * the case, then the subdomain for all your endpoints will be "test"
     * thats why it has been set as the default , OR if you are 
     * using the production verified accound details ,  
     * then it will be "www"  
     */

    'subdomain_for_endpoints' => 'test',
];
