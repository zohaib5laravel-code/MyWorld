<?php

namespace Database\Seeders;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {

  
        $posts = [
            // Mountains Posts
            [
                'title' => 'Conquering the Mighty Everest: A Journey to the Top of the World',
                'slug' => Str::slug('Conquering the Mighty Everest: A Journey to the Top of the World') . '-' . uniqid(),
                'excerpt' => 'An exhilarating account of climbing Mount Everest, the challenges faced, and the breathtaking views from the summit.',
                'content' => '<h2>The Ultimate Challenge</h2>
<p>Mount Everest, standing at 8,848 meters, represents the pinnacle of mountain climbing achievement. This journey tests not only physical endurance but mental fortitude.</p>

<h3>Preparation and Training</h3>
<p>Preparing for Everest requires months, sometimes years, of rigorous training. Climbers must acclimatize to high altitudes, build cardiovascular endurance, and develop technical climbing skills.</p>

<h3>The Ascent</h3>
<p>The climb involves navigating through treacherous icefalls, steep inclines, and unpredictable weather conditions. The final push to the summit is both physically demanding and emotionally overwhelming.</p>

<h3>At the Summit</h3>
<p>Reaching the summit offers a perspective few ever experience. The world stretches out below, a tapestry of clouds and peaks that reminds us of our place in nature\'s grandeur.</p>',
                'category_id' => 2,
                'featured_image' => 'mountain_everest.jpg',
                'status' => 'published',
                'views' => rand(1500, 5000),
                'published_at' => Carbon::now()->subDays(rand(1, 30)),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'The Alps: Europe\'s Natural Playground',
                'slug' => Str::slug('The Alps: Europe\'s Natural Playground') . '-' . uniqid(),
                'excerpt' => 'Exploring the diverse landscapes and activities the Alps offer throughout the year.',
                'content' => '<h2>A Year-Round Destination</h2>
<p>The Alps transform with the seasons, offering unique experiences whether you visit in summer or winter.</p>

<h3>Winter Wonderland</h3>
<p>During winter, the Alps become a skier\'s paradise with world-class resorts like Chamonix, St. Moritz, and Zermatt offering slopes for all skill levels.</p>

<h3>Summer Adventures</h3>
<p>When the snow melts, hiking trails reveal wildflower meadows, crystal-clear lakes, and opportunities for mountaineering and rock climbing.</p>

<h3>Alpine Culture</h3>
<p>The region boasts rich traditions, from Swiss chocolate making to Austrian mountain music, making every visit culturally enriching.</p>',
                'category_id' => 2,
                'featured_image' => 'alps_landscape.jpg',
                'status' => 'published',
                'views' => rand(800, 3000),
                'published_at' => Carbon::now()->subDays(rand(1, 60)),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Rocky Mountains: America\'s Backbone',
                'slug' => Str::slug('Rocky Mountains: America\'s Backbone') . '-' . uniqid(),
                'excerpt' => 'Discover the geological wonders and diverse wildlife of North America\'s Rocky Mountains.',
                'content' => '<h2>Geological Marvel</h2>
<p>The Rocky Mountains stretch over 3,000 miles from Canada to New Mexico, showcasing spectacular geological formations.</p>

<h3>National Parks</h3>
<p>Explore iconic parks like Yellowstone, Rocky Mountain National Park, and Glacier National Park, each offering unique ecosystems and wildlife.</p>

<h3>Wildlife Encounters</h3>
<p>From grizzly bears and elk to bighorn sheep and mountain lions, the Rockies are home to some of North America\'s most iconic animals.</p>

<h3>Conservation Efforts</h3>
<p>Learn about ongoing efforts to preserve this vital ecosystem for future generations.</p>',
                'category_id' => 2,
                'featured_image' => 'rocky_mountains.jpg',
                'status' => 'published',
                'views' => rand(1200, 4000),
                'published_at' => Carbon::now()->subDays(rand(1, 90)),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Andes Mountains: The Longest Continental Mountain Range',
                'slug' => Str::slug('Andes Mountains: The Longest Continental Mountain Range') . '-' . uniqid(),
                'excerpt' => 'Exploring the cultural and natural significance of South America\'s Andes Mountains.',
                'content' => '<h2>Ancient Civilizations</h2>
<p>The Andes were home to the Inca Empire, whose engineering marvels like Machu Picchu continue to astound visitors.</p>

<h3>Biodiversity Hotspot</h3>
<p>From llamas and alpacas to spectacled bears and Andean condors, the region supports diverse wildlife adapted to high altitudes.</p>

<h3>Climate Zones</h3>
<p>Experience everything from tropical rainforests to glaciers within this remarkable mountain range.</p>',
                'category_id' => 2,
                'featured_image' => 'andes_mountains.jpg',
                'status' => 'published',
                'views' => rand(900, 2500),
                'published_at' => Carbon::now()->subDays(rand(1, 120)),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Forests Posts
            [
                'title' => 'Amazon Rainforest: Earth\'s Lungs',
                'slug' => Str::slug('Amazon Rainforest: Earth\'s Lungs') . '-' . uniqid(),
                'excerpt' => 'Understanding the vital role of the Amazon rainforest in global climate regulation.',
                'content' => '<h2>The World\'s Largest Rainforest</h2>
<p>Covering 5.5 million square kilometers, the Amazon produces 20% of the world\'s oxygen.</p>

<h3>Incredible Biodiversity</h3>
<p>Home to 10% of the world\'s known species, including jaguars, pink dolphins, and countless plant species with medicinal properties.</p>

<h3>Indigenous Communities</h3>
<p>Learn about the traditional knowledge and sustainable practices of indigenous Amazonian tribes.</p>

<h3>Conservation Challenges</h3>
<p>Addressing deforestation and promoting sustainable development in this critical ecosystem.</p>',
                'category_id' => 3,
                'featured_image' => 'amazon_rainforest.jpg',
                'status' => 'published',
                'views' => rand(2000, 6000),
                'published_at' => Carbon::now()->subDays(rand(1, 45)),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Redwood Forests: Walking Among Giants',
                'slug' => Str::slug('Redwood Forests: Walking Among Giants') . '-' . uniqid(),
                'excerpt' => 'Experiencing the awe-inspiring majesty of California\'s ancient redwood trees.',
                'content' => '<h2>Living Monuments</h2>
<p>Some redwoods have stood for over 2,000 years, witnessing centuries of history.</p>

<h3>Coastal vs. Giant Redwoods</h3>
<p>Explore the differences between coastal redwoods (the tallest trees) and giant sequoias (the largest by volume).</p>

<h3>Forest Ecology</h3>
<p>Discover how these giant trees support entire ecosystems, from canopy dwellers to forest floor inhabitants.</p>

<h3>Preservation Success</h3>
<p>Learn about conservation efforts that have saved these forests from extinction.</p>',
                'category_id' => 3,
                'featured_image' => 'redwood_forest.jpg',
                'status' => 'published',
                'views' => rand(1100, 3500),
                'published_at' => Carbon::now()->subDays(rand(1, 75)),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Boreal Forests: The Great Northern Wilderness',
                'slug' => Str::slug('Boreal Forests: The Great Northern Wilderness') . '-' . uniqid(),
                'excerpt' => 'Exploring the vast coniferous forests that circle the northern hemisphere.',
                'content' => '<h2>The World\'s Largest Land Biome</h2>
<p>Boreal forests cover 17% of the Earth\'s land surface, playing a crucial role in carbon storage.</p>

<h3>Adapted Wildlife</h3>
<p>From moose and wolves to migratory birds, discover how animals survive the harsh northern winters.</p>

<h3>Seasonal Transformations</h3>
<p>Witness the dramatic changes from summer\'s midnight sun to winter\'s frozen wonderland.</p>

<h3>Climate Change Impact</h3>
<p>Understanding how warming temperatures are affecting these critical ecosystems.</p>',
                'category_id' => 3,
                'featured_image' => 'boreal_forest.jpg',
                'status' => 'published',
                'views' => rand(700, 2200),
                'published_at' => Carbon::now()->subDays(rand(1, 100)),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mangrove Forests: Coastal Guardians',
                'slug' => Str::slug('Mangrove Forests: Coastal Guardians') . '-' . uniqid(),
                'excerpt' => 'How mangrove forests protect coastlines and support marine life.',
                'content' => '<h2>Natural Coastal Defense</h2>
<p>Mangroves reduce wave energy by 75%, protecting shorelines from erosion and storm damage.</p>

<h3>Nursery of the Sea</h3>
<p>These forests provide breeding grounds for 75% of commercially caught fish species.</p>

<h3>Unique Adaptations</h3>
<p>Discover how mangrove trees survive in salty water through specialized root systems.</p>

<h3>Carbon Storage Powerhouses</h3>
<p>Mangroves store up to 5 times more carbon per hectare than tropical rainforests.</p>',
                'category_id' => 3,
                'featured_image' => 'mangrove_forest.jpg',
                'status' => 'published',
                'views' => rand(800, 2800),
                'published_at' => Carbon::now()->subDays(rand(1, 85)),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Oceans Posts
            [
                'title' => 'Great Barrier Reef: Underwater Paradise',
                'slug' => Str::slug('Great Barrier Reef: Underwater Paradise') . '-' . uniqid(),
                'excerpt' => 'Exploring the world\'s largest coral reef system and its incredible marine biodiversity.',
                'content' => '<h2>A World Heritage Wonder</h2>
<p>Stretching over 2,300 kilometers, the Great Barrier Reef is visible from space and supports incredible marine life.</p>

<h3>Coral Diversity</h3>
<p>Home to 400 types of coral, 1,500 species of fish, and 4,000 types of mollusk.</p>

<h3>Marine Life Spectacle</h3>
<p>Swim with turtles, dolphins, reef sharks, and the iconic clownfish in their natural habitat.</p>

<h3>Conservation Initiatives</h3>
<p>Learn about efforts to protect the reef from climate change, pollution, and coral bleaching.</p>',
                'category_id' => 1,
                'featured_image' => 'great_barrier_reef.jpg',
                'status' => 'published',
                'views' => rand(1800, 5500),
                'published_at' => Carbon::now()->subDays(rand(1, 50)),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Mariana Trench: Journey to the Deepest Point on Earth',
                'slug' => Str::slug('Mariana Trench: Journey to the Deepest Point on Earth') . '-' . uniqid(),
                'excerpt' => 'Exploring the mysteries of the ocean\'s deepest point and its unique ecosystem.',
                'content' => '<h2>The Final Frontier</h2>
<p>At nearly 11 kilometers deep, the Mariana Trench remains one of the least explored places on Earth.</p>

<h3>Extreme Conditions</h3>
<p>Discover how life survives under immense pressure, complete darkness, and near-freezing temperatures.</p>

<h3>Strange Creatures</h3>
<p>Meet the alien-like inhabitants including giant amphipods, snailfish, and bioluminescent organisms.</p>

<h3>Scientific Discoveries</h3>
<p>Learn what recent expeditions have revealed about this mysterious underwater world.</p>',
                'category_id' => 1,
                'featured_image' => 'mariana_trench.jpg',
                'status' => 'published',
                'views' => rand(1300, 4200),
                'published_at' => Carbon::now()->subDays(rand(1, 65)),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Whale Watching: Majestic Giants of the Ocean',
                'slug' => Str::slug('Whale Watching: Majestic Giants of the Ocean') . '-' . uniqid(),
                'excerpt' => 'A guide to responsible whale watching and understanding these magnificent marine mammals.',
                'content' => '<h2>Ocean Giants</h2>
<p>From the massive blue whale to the acrobatic humpback, discover the diversity of whale species.</p>

<h3>Migration Patterns</h3>
<p>Follow the incredible journeys whales make annually between feeding and breeding grounds.</p>

<h3>Whale Behavior</h3>
<p>Learn about breaching, singing, bubble-net feeding, and other fascinating whale behaviors.</p>

<h3>Conservation Success Stories</h3>
<p>How international protection efforts have helped whale populations recover from near extinction.</p>',
                'category_id' => 1,
                'featured_image' => 'whale_watching.jpg',
                'status' => 'published',
                'views' => rand(950, 3200),
                'published_at' => Carbon::now()->subDays(rand(1, 80)),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Coral Reefs: Rainforests of the Sea',
                'slug' => Str::slug('Coral Reefs: Rainforests of the Sea') . '-' . uniqid(),
                'excerpt' => 'Understanding the vital importance of coral reefs and the threats they face.',
                'content' => '<h2>Biodiversity Hotspots</h2>
<p>Though they cover less than 1% of the ocean floor, coral reefs support 25% of all marine species.</p>

<h3>Coral Biology</h3>
<p>Discover how these tiny animals create massive structures through symbiotic relationships with algae.</p>

<h3>Ecosystem Services</h3>
<p>Reefs provide coastal protection, support fisheries, and contribute to tourism economies.</p>

<h3>Restoration Efforts</h3>
<p>Innovative approaches to coral gardening, artificial reefs, and conservation initiatives.</p>',
                'category_id' => 1,
                'featured_image' => 'coral_reefs.jpg',
                'status' => 'published',
                'views' => rand(1400, 3800),
                'published_at' => Carbon::now()->subDays(rand(1, 95)),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert posts
        foreach ($posts as $postData) {
            // Check if post already exists by slug
            $existingPost = Post::where('slug', $postData['slug'])->first();
            
            if (!$existingPost) {
                Post::insert($postData);
            }
        }

        // Add some draft posts
        $draftPosts = [
            [
                'title' => 'Exploring the Himalayas: More Than Just Mountains',
                'slug' => Str::slug('Exploring the Himalayas: More Than Just Mountains') . '-' . uniqid(),
                'excerpt' => 'Discover the cultural and spiritual significance of the Himalayan region.',
                'content' => '<p>Content being prepared...</p>',
                'category_id' => 2,
                'featured_image' => 'himalayas_draft.jpg',
                'status' => 'draft',
                'views' => 0,
                'published_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sustainable Forestry Practices for the Future',
                'slug' => Str::slug('Sustainable Forestry Practices for the Future') . '-' . uniqid(),
                'excerpt' => 'How modern forestry balances resource use with conservation.',
                'content' => '<p>Content being prepared...</p>',
                'category_id' => 3,
                'featured_image' => 'sustainable_forestry.jpg',
                'status' => 'draft',
                'views' => 0,
                'published_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($draftPosts as $postData) {
            $existingPost = Post::where('slug', $postData['slug'])->first();
            
            if (!$existingPost) {
                Post::insert($postData);
            }
        }



    }
}
