<?php
/*
 * This file is a part of Mibew Jabber Plugin.
 *
 * Copyright 2017-2019 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Mibew\Mibew\Plugin\Jabber;

use Fabiang\Xmpp\Options;
use Fabiang\Xmpp\Client;
use Fabiang\Xmpp\Protocol\Message;
use Mibew\EventDispatcher\EventDispatcher;
use Mibew\EventDispatcher\Events;
use Symfony\Component\HttpFoundation\Request;

class Plugin extends \Mibew\Plugin\AbstractPlugin implements \Mibew\Plugin\PluginInterface
{

    protected $initialized = false;

    private $rcpts = array();

    public function __construct($config)
    {
        parent::__construct($config);

        // Use autoloader for Composer's packages that shipped with the plugin
        require(__DIR__ . '/vendor/autoload.php');

        // Check configuration and initialize the plugin
        if (isset($config['server'])
            && isset($config['username'])
            && isset($config['password'])
            && isset($config['rcpt'])) {

        // Store chat IDs to notify as an array
            if (is_array($config['rcpt'])) {
                $this->rcpts = $config['rcpt'];
            }
            else {
                $this->rcpts[] = $config['rcpt'];
            }

            $this->initialized = true;
        }
    }

    /**
     * This creates the listener that listens for new
     * threads to send out notifications
     */
    public function run()
    {
        $dispatcher = EventDispatcher::getInstance();
        $dispatcher->attachListener(Events::THREAD_CREATE, $this, 'sendJabberNotification');
    }

    /**
     * Sends notification to Jabber
     * @return boolean
     */
    public function sendJabberNotification(&$args)
    {
        // Initialize jabber connection
        $options = new Options($this->config['server']);
        $options->setUsername($this->config['username'])
                ->setPassword($this->config['password']);

        $client = new Client($options);
        $client->connect();

        // Prepare the notification
        $message = new Message;
        $message->setMessage(getlocal('You have a new user waiting for a response. Username: {0}', array($args['thread']->userName)));

        // Send the notification to all recipients
        foreach ($this->rcpts as $rcpt) {
            $message->setTo($rcpt);
            $client->send($message);
        }

        return true;
    }

    /**
     * Returns plugin's version.
     *
     * @return string
     */
    public static function getVersion()
    {
        return '0.0.1';
    }

    /**
     * Returns plugin's dependencies.
     *
     * @return type
     */
    public static function getDependencies()
    {
        return array();
    }
}
