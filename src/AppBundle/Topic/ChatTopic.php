<?php

namespace AppBundle\Topic;


use Gos\Bundle\WebSocketBundle\Router\WampRequest;
use Gos\Bundle\WebSocketBundle\Topic\TopicInterface;
use Gos\Bundle\WebSocketBundle\Topic\TopicPeriodicTimer;
use Gos\Bundle\WebSocketBundle\Topic\TopicPeriodicTimerInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\Topic;

class ChatTopic implements TopicInterface, TopicPeriodicTimerInterface
{
    /**
     * @var TopicPeriodicTimer
     */
    protected $periodicTimer;

    /**
     * @param TopicPeriodicTimer $periodicTimer
     */
    public function setPeriodicTimer(TopicPeriodicTimer $periodicTimer)
    {
        $this->periodicTimer = $periodicTimer;
    }

    /**
     * @param Topic $topic
     *
     * @return array
     */
    public function registerPeriodicTimer(Topic $topic)
    {
        //add
        $this->periodicTimer->addPeriodicTimer($this, 'hello', 2, function () use ($topic) {
            $topic->broadcast('hello world');
        });

        //exist
        $this->periodicTimer->isPeriodicTimerActive($this, 'hello'); // true or false

        //remove
        $this->periodicTimer->cancelPeriodicTimer($this, 'hello');
    }

    public function onSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        $room = $request->getAttributes()->get('room');
        $userId = $request->getAttributes()->get('user_id');
        $str = ' new user income in room = ' . $room . ' to userId = ' . $userId;

        $arr = [
            "type" => "message:service",
            "body" => [
                "message" => $str,
                "date" => date_create()->getTimestamp()
            ],
            "version" => "1.0.0"];

        var_dump($arr);
        echo json_encode($arr);
        //this will broadcast the message to ALL subscribers of this topic.
        $topic->broadcast(['msg' => $arr]);
    }

    public function onUnSubscribe(ConnectionInterface $connection, Topic $topic, WampRequest $request)
    {
        $room = $request->getAttributes()->get('room');
        $userId = $request->getAttributes()->get('user_id');

        //this will broadcast the message to ALL subscribers of this topic.
        $topic->broadcast(['msg' => 'Новый пользователь вышел из комнаты ' . $room . ' лички с пользователем ' . $userId]);
    }

    public function onPublish(ConnectionInterface $connection, Topic $topic, WampRequest $request, $event, array $exclude, array $eligible)
    {
        $room = $request->getAttributes()->get('room');
        $userId = $request->getAttributes()->get('user_id');
        var_dump($event);
        $topic->broadcast([
//            'msg' => 'В комнату ' . $room . ' пользователю ' . $userId . ' поступило сообщение: ' . $event,
            'msg' => $event
        ]);
    }

    public function getName()
    {
        return 'app.topic.chat';
    }


}