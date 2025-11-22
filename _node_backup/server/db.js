const mysql = require("mysql2/promise");
require("dotenv").config();

const pool = mysql.createPool({
  host: process.env.DB_HOST || "localhost",
  user: process.env.DB_USER || "nuevo_usuario",
  password: process.env.DB_PASSWORD || "nueva_contraseña",
  database: process.env.DB_NAME || "api_db",
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0,
});

const initDB = async () => {
  try {
    const connection = await pool.getConnection();
    console.log("Connected to database.");

    const createTableQuery = `
      CREATE TABLE IF NOT EXISTS url_shorter_db (
        id INT AUTO_INCREMENT PRIMARY KEY,
        original_url TEXT NOT NULL,
        short_code VARCHAR(10) NOT NULL UNIQUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        clicks INT DEFAULT 0
      )
    `;

    await connection.query(createTableQuery);
    console.log("Table url_shorter_db checked/created.");
    connection.release();
  } catch (error) {
    console.error("Database initialization error:", error);
  }
};

module.exports = { pool, initDB };
