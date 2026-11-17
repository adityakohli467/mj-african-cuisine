# M.J African Cuisine website

A responsive, static HTML/CSS/JavaScript restaurant website preview.

## Run locally
Open `index.html` in a browser, or run a local server from this folder:
`python -m http.server 8000`
Then visit `http://localhost:8000`.

## Before presenting as final
Replace the sample menu items/prices, address, phone, email, opening hours, testimonials and photos in `index.html`. The logo is in `assets/logo.jpeg`. Food photography currently loads from Unsplash URLs and requires an internet connection.

## Deploy to Vercel
1. Create a GitHub repository and upload the contents of this folder (keep `index.html` at the repository root and include `assets/logo.jpeg`).
2. Sign in to https://vercel.com and choose **Add New → Project**.
3. Import the GitHub repository.
4. For a plain HTML site, leave Framework Preset as **Other**. No build command is needed. Leave the output directory blank or set it to `.`.
5. Click **Deploy**. Vercel will provide a public `*.vercel.app` URL to share with your client.
6. Whenever you push updates to the connected GitHub branch, Vercel automatically redeploys the site.

Alternative: install Vercel CLI (`npm i -g vercel`), open a terminal in this folder and run `vercel`; follow the prompts. Use `vercel --prod` when you are ready to publish production changes.
