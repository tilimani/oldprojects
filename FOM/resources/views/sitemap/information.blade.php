<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
      <loc>https://getvico.com/</loc>
      <lastmod>{{$house->updated_at->tz('UTC')->toAtomString()}}</lastmod>
      <priority>1.00</priority>
    </url>
    <url>
      <loc>https://getvico.com/about</loc>
      <lastmod>{{$house->updated_at->tz('UTC')->toAtomString()}}</lastmod>
      <priority>0.80</priority>
    </url>
    <url>
      <loc>https://getvico.com/questions/host</loc>
      <lastmod>{{$house->updated_at->tz('UTC')->toAtomString()}}</lastmod>
      <priority>0.80</priority>
    </url>
    <url>
      <loc>https://getvico.com/questions/user</loc>
      <lastmod>{{$house->updated_at->tz('UTC')->toAtomString()}}</lastmod>
      <priority>0.80</priority>
    </url>
    <url>
      <loc>https://getvico.com/bogota/alojamiento-habitaciones-estudiantes</loc>
      <lastmod>{{$house->updated_at->tz('UTC')->toAtomString()}}</lastmod>
      <priority>0.80</priority>
    </url>
    <url>
      <loc>https://getvico.com/addvico</loc>
      <lastmod>{{$house->updated_at->tz('UTC')->toAtomString()}}</lastmod>
      <priority>0.80</priority>
    </url>
    <url>
      <loc>https://getvico.com/termsandconditions/version/1</loc>
      <lastmod>{{$house->updated_at->tz('UTC')->toAtomString()}}</lastmod>
      <priority>0.51</priority>
    </url>
</urlset>
