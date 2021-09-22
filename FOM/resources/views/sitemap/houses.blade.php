<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($houses as $house)
        <url>
            <loc>https://getvico.com/houses/{{ $house->id }}</loc>
            <lastmod>{{ $house->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>@if($house->isVip())0.64 @else 0.51 @endif</priority>
        </url>
    @endforeach
</urlset>
