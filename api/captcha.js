const crypto = require("crypto");

module.exports = (req, res) => {
  if (req.method !== "GET") {
    res.setHeader("Allow", "GET");
    return res.status(405).end("Method not allowed");
  }

  const secret = process.env.CAPTCHA_SECRET;
  if (!secret) {
    res.setHeader("Cache-Control", "no-store");
    return res.status(500).send("Missing CAPTCHA_SECRET environment variable");
  }

  const code = String(crypto.randomInt(1000, 10000));

  const expires = Date.now() + 10 * 60 * 1000;
  const payload = Buffer.from(JSON.stringify({ code, expires })).toString("base64url");
  const signature = crypto.createHmac("sha256", secret).update(payload).digest("base64url");
  const token = payload + "." + signature;

  res.setHeader("Set-Cookie", "mj_captcha=" + token + "; Path=/; HttpOnly; Secure; SameSite=Lax; Max-Age=600");
  res.setHeader("Cache-Control", "no-store, no-cache, must-revalidate, max-age=0");
  res.setHeader("Pragma", "no-cache");
  res.setHeader("Content-Type", "image/svg+xml; charset=utf-8");

  const lines = Array.from({ length: 6 }, () => {
    const x1 = crypto.randomInt(0, 121);
    const y1 = crypto.randomInt(0, 49);
    const x2 = crypto.randomInt(0, 121);
    const y2 = crypto.randomInt(0, 49);
    return '<line x1="' + x1 + '" y1="' + y1 + '" x2="' + x2 + '" y2="' + y2 + '" stroke="#cdae7d" stroke-width="1"/>';
  }).join("");

  return res.status(200).send(
    '<svg xmlns="http://www.w3.org/2000/svg" width="120" height="48" viewBox="0 0 120 48" role="img" aria-label="Four digit verification code">' +
    '<rect width="120" height="48" rx="4" fill="#fffaf1"/>' + lines +
    '<text x="60" y="32" text-anchor="middle" font-family="Arial,sans-serif" font-size="23" font-weight="bold" letter-spacing="4" fill="#231b12">' +
    code + '</text></svg>'
  );
};
