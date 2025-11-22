const express = require("express");
const cors = require("cors");
const { nanoid } = require("nanoid");
const { pool, initDB } = require("./db");
require("dotenv").config();

const app = express();
const PORT = process.env.PORT || 3000;

app.use(cors());
app.use(express.json());

// Initialize Database
initDB();

// Shorten URL Endpoint
app.post("/api/shorten", async (req, res) => {
  const { originalUrl } = req.body;

  if (!originalUrl) {
    return res.status(400).json({ error: "URL is required" });
  }

  try {
    const shortCode = nanoid(6); // Generate a 6-character ID
    const [result] = await pool.query(
      "INSERT INTO url_shorter_db (original_url, short_code) VALUES (?, ?)",
      [originalUrl, shortCode]
    );

    res.json({
      originalUrl,
      shortCode,
      shortUrl: `http://localhost:${PORT}/${shortCode}`,
    });
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: "Server error" });
  }
});

// Redirect Endpoint
app.get("/:code", async (req, res) => {
  const { code } = req.params;

  try {
    const [rows] = await pool.query(
      "SELECT original_url FROM url_shorter_db WHERE short_code = ?",
      [code]
    );

    if (rows.length > 0) {
      const originalUrl = rows[0].original_url;

      // Increment clicks asynchronously
      pool.query(
        "UPDATE url_shorter_db SET clicks = clicks + 1 WHERE short_code = ?",
        [code]
      );

      return res.redirect(originalUrl);
    } else {
      return res.status(404).send("URL not found");
    }
  } catch (error) {
    console.error(error);
    res.status(500).send("Server error");
  }
});

// Stats Endpoint (Optional but useful)
app.get("/api/stats/:code", async (req, res) => {
  const { code } = req.params;

  try {
    const [rows] = await pool.query(
      "SELECT * FROM url_shorter_db WHERE short_code = ?",
      [code]
    );

    if (rows.length > 0) {
      res.json(rows[0]);
    } else {
      res.status(404).json({ error: "URL not found" });
    }
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: "Server error" });
  }
});

app.listen(PORT, () => {
  console.log(`Server running on http://localhost:${PORT}`);
});
