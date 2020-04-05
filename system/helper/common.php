<?php
/**
 * Licensed to the Apache Software Foundation (ASF) under one or more
 * contributor license agreements. See the NOTICE file distributed with
 * this work for additional information regarding copyright ownership.
 * The ASF licenses this file to You under the Apache License, Version 2.0
 * (the "License"); you may not use this file except in compliance with
 * the License. You may obtain a copy of the License at
 *
 *         http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */


class Common{

    private static $request;
    private static $status = 1;
    private static $log;
    private static $error_log;
    private static $open = 0;

    public function __construct() {
        Logger::configure(self::config());
        self::$log = Logger::getLogger('default');
        self::$error_log = Logger::getLogger('errorLogger');
        self::$open = 1;
    }
    
    public static function setRequest($request){
        self::$request = $request;
    }

    public static function setOpen(){
        if(!self::$open) {
            new Common();
        }
    }

    /**
     * Function 配置信息
     * @return array
     */
    public static function config(){
        $app_code = 'buy';
        $config = [
            'appenders' => [
                'default' => [
                    'class' => 'LoggerAppenderDailyFile',
                    'level' => 'ALL',
                    'layout' => [
                        'class' => 'LoggerLayoutPattern',
                        'params' => [
                            'conversionPattern' => '%d{Y-m-d H:m:s.u} %-5p [' . $app_code . '] --- [%t] %C%L : %m%n',
                        ]
                    ],
                    'params' => [
                        'file' => DIR_LOGS . $app_code . '-%s.log',
                        'datePattern' => 'Y-m-d',
                        'append' => true
                    ]
                ],
                'errorAppender' => [
                    'class' => 'LoggerAppenderDailyFile',
                    'level' => 'ERROR',
                    'layout' => [
                        'class' => 'LoggerLayoutPattern',
                        'params' => [
                            'conversionPattern' => '%d{Y-m-d H:m:s.u} %-5p [' . $app_code . '] --- [%t] %C%L : %m%n',
                        ]
                    ],
                    'params' => [
                        'file' => DIR_LOGS . $app_code . '-error-%s.log',
                        'datePattern' => 'Y-m-d',
                        'append' => true
                    ]
                ],
            ],
            'loggers' => [
                'errorLogger' => [
                    'appenders' => ['errorAppender'],
                ]
            ],
            'rootLogger' => [
                'appenders' => ['default'],
            ],

        ];
        return $config;
    }


    /**
     * Function 错误级别日志
     * 会同时产生一条info日志和error日志
     * @version
     * @date 2020/3/13 10:33
     * @param $message
     * @param array $context
     */
    public static function error($message, array $context = array()) {
        if(self::$status){
            self::setOpen();
            try{
                self::$error_log->error(self::interpolate($message, $context));
            }catch(Exception $e){

            }
        }

    }

    /**
     * Function 普通日志
     * @version
     * @date 2020/3/13 10:34
     * @param $message
     * @param array $context
     */
    public static function info($message, array $context = array())
    {
        if (self::$status) {
            self::setOpen();
            try {
                self::$log->info(self::interpolate($message, $context));
            } catch (Exception $e) {

            }
        }
    }

    /**
     * Function 捕获异常日志
     * 记录更详细的信息,请直接传入异常
     * @param $e
     * @version
     * @date 2020/3/13 9:06
     */
    public static function exception($e) {
        if (self::$status) {
            self::setOpen();
            try {
                self::$error_log->error(self::interpolate(json_encode($e)));
            } catch (Exception $e) {

            }
        }
    }

    /**
     * Function 替换字符
     * @author zt7672
     * @version
     * @date 2020/3/12 18:18
     * @param $message
     * @param array $context
     * @return string
     */
    protected static function interpolate($message, array $context = array()) {
        if(is_array($message)){
            $message = json_encode($message);
        }
        $replace = array();
        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }
        $message = strtr($message, $replace);
        if(!empty(self::$request)){
            $message .=  '-Params:' .json_encode(self::$request);
        }
        return $message;
    }
}

