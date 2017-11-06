<?php

use Ratchet\Wamp\WampConnection;
use Eole\Sandstone\Websocket\Topic;

class ChatTopic extends Topic
{
    /**
     * Broadcast message to each subscribing client.
     *
     * {@InheritDoc}
     */
    public function onPublish(Ratchet\Wamp\WampConnection $conn, $topic, $event)
    {
        $this->broadcast([
            'message' => $event,
        ]);
    }
}
