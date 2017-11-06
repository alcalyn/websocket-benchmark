const fs = require('fs');
const casper = require('casper').create();

casper.options.waitTimeout = 15000;

const techno = casper.cli.args[0];
const env = {
    nodejs: {
        host: 'http://0.0.0.0:3000',
        logFile: 'wait-time.nodejs.log'
    },
    php: {
        host: 'http://0.0.0.0:3001',
        logFile: 'wait-time.php.log'
    },
    mock: {
        host: 'http://0.0.0.0:3002',
        logFile: 'wait-time.mock.log'
    }
}[techno];


console.log('Running benchmark for '+techno);

casper.start(env.host, function() {
    this.echo(this.getTitle());

    const message = 'Hello, my name is '+Math.random().toString(36).substr(2);

    this.echo('Writing my message: '+message);
    this.sendKeys('#m', message);

    this.echo('I send my message');
    this.clickLabel('Send', 'button');
    const start = new Date();

    this.waitForText(message, function () {
        this.echo('Ok I see the message I just sent.');
        const end = new Date();
        fs.write(env.logFile, (start - 0)+'-'+(end - 0)+"\n", 'a');
    });
});

casper.run();
