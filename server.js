const WebSocket = require('ws');
/*const https = require('https');
const fs = require('fs');

const server = https.createServer({
    cert: fs.readFileSync("/home/xbrhlik/webte.fei.stuba.sk-chain-cert.pem"),
    key: fs.readFileSync("/home/xbrhlik/webte.fei.stuba.sk.key")
})

server.listen(9000);

const ws = new WebSocket.Server( {server});*/
const ws = new WebSocket.Server( { port: 9000 });

let messages = [];


ws.on('connection', (socket) => {
    console.log("New Connection");

    socket.on("message", (data) =>{
        const msg = data.toString()
        const received = JSON.parse(msg);
        console.log(received);
        ws.clients.forEach(client => {
            client.send(msg);
        })
    })
})
