
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    
   <sitemap>

      <loc>https://www.getvico.com/sitemap/information.xml</loc>

      <lastmod>{{$house->updated_at->tz('UTC')->toAtomString()}}</lastmod>

   </sitemap>   

   <sitemap>

      <loc>https://www.getvico.com/sitemap/houses.xml</loc>

      <lastmod>{{$house->updated_at->tz('UTC')->toAtomString()}}</lastmod>

   </sitemap>

   <sitemap>

      <loc>https://www.getvico.com/blog/post-sitemap.xml</loc>

      <lastmod>{{$house->updated_at->tz('UTC')->toAtomString()}}</lastmod>

   </sitemap>

   <sitemap>

      <loc>https://www.getvico.com/blog/page-sitemap.xml</loc>

      <lastmod>{{$house->updated_at->tz('UTC')->toAtomString()}}</lastmod>

   </sitemap>

</sitemapindex>