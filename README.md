Websocket benchmark, NodeJS VS PHP
==================================

Run a simple chat application.

One is powered by socket.io (just reused the [official chat example](https://github.com/socketio/chat-example)),
and the other one is powered by [Sandstone](https://github.com/eole-io/sandstone).

They have both the same front web interface.

A same phantomJS script will create many users simultaneously sending messages.

The script will then measure some metrics, like delay between message send and receive.

Then benchmark result is rendered into a graphic.


## Install

Needs NodeJs, npm, ZMQ, PHP, php-zmq, composer, GNU parallel (`apt-get install parallel`)

``` bash
git clone git@github.com:alcalyn/websocket-benchmark.git
cd websocket-benchmark/

npm install

# Install nodejs chat
cd chat-example/
npm install
cd ../

# Install PHP chat
cd sandstone-chat/
composer install
cd ../
```


## Usage

You need to run either nodejs or PHP chat (not both at same time),
then run benchmark.

### Run chat app (either nodejs or PHP)

#### Run socket.io chat

``` bash
# In a process
cd chat-example/
npm start
```

#### Run Sandstone chat

``` bash
# In a process
cd sandstone/
php chat-server.php

# In another process
cd sandstone/
php -S 0.0.0.0:3000
```

### Run benchmark

``` bash
parallel -j 5 ::: ./node_modules/.bin/casperjs ::: run.js ::: {1..500}
```

### Render results

``` php
php parse.php > data.js
```

Then open `view.html` in browser.
