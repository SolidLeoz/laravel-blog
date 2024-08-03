# Laravel Personal Blog

Un blog personale robusto e facile da usare, sviluppato con Laravel. Questo progetto offre una piattaforma per la gestione di contenuti blog con funzionalità di amministrazione integrate.

## Caratteristiche

- Autenticazione admin
- Creazione, modifica ed eliminazione di post
- Supporto per l'upload di immagini e video nei post
- Sistema di tagging per i post
- Interfaccia utente responsive
- Ricerca dei post
- Paginazione

## Requisiti

- PHP >= 8.1
- Composer
- MySQL
- Node.js e NPM

## Installazione

1. Clona il repository:
   ```
   git clone https://github.com/yourusername/laravel-personal-blog.git
   ```

2. Entra nella directory del progetto:
   ```
   cd laravel-personal-blog
   ```

3. Installa le dipendenze PHP:
   ```
   composer install
   ```

4. Installa le dipendenze JavaScript:
   ```
   npm install && npm run dev
   ```

5. Copia il file di configurazione:
   ```
   cp .env.example .env
   ```

6. Genera una chiave dell'applicazione:
   ```
   php artisan key:generate
   ```

7. Configura il database nel file `.env`

8. Esegui le migrazioni:
   ```
   php artisan migrate
   ```

9. Crea il link simbolico per lo storage:
   ```
   php artisan storage:link
   ```

## Utilizzo

1. Avvia il server di sviluppo:
   ```
   php artisan serve
   ```

2. Visita `http://localhost:8000` nel tuo browser

3. Accedi all'area admin utilizzando le credenziali configurate

## Contribuire

Siamo aperti a contributi! Per favore, segui questi passaggi:

1. Forka il repository
2. Crea un nuovo branch (`git checkout -b feature/AmazingFeature`)
3. Committa le tue modifiche (`git commit -m 'Add some AmazingFeature'`)
4. Pusha il branch (`git push origin feature/AmazingFeature`)
5. Apri una Pull Request

## Licenza

Distribuito sotto la licenza MIT. Vedi `LICENSE` per maggiori informazioni.

## Contatti

- prclrd@gmail.com