// server.js — Serveur Node.js natif (sans Express)
// Sert les fichiers statiques du projet (HTML, CSS)
// Démarrage : node server.js

const http = require('http') // module natif Node.js
const fs   = require('fs')   // pour lire les fichiers
const path = require('path') // pour gérer les chemins

const PORT = 3001

// Table des types de fichiers
const mimeTypes = {
  '.html': 'text/html',
  '.css' : 'text/css',
  '.js'  : 'application/javascript',
}

// On crée le serveur
const server = http.createServer((req, res) => {
  // Si l'URL est "/" on sert index.html
  let filePath = req.url === '/' ? './index.html' : '.' + req.url

  const extension  = path.extname(filePath)
  const contentType = mimeTypes[extension] || 'text/plain'

  // On lit le fichier demandé
  fs.readFile(filePath, (err, content) => {
    if (err) {
      res.writeHead(404)
      res.end('Fichier non trouvé')
      return
    }

    res.writeHead(200, { 'Content-Type': contentType })
    res.end(content)
  })
})

// On démarre le serveur sur le port 3001
server.listen(PORT, () => {
  console.log(`Serveur Node.js démarré → http://localhost:${PORT}`)
})
