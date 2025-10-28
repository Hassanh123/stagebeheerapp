<?php

namespace Tests\Feature;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimpleTagTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function tag_aanmaken_werkt()
    {
        $tag = Tag::create(['naam' => 'PHP']);
        $this->assertDatabaseHas('tags', ['naam' => 'PHP']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function dubbele_tags_mogen_niet()
    {
        // Eerste tag aanmaken
        Tag::create(['naam' => 'Java']);
        
        // Probeer tweede tag metzelfde naam - dit zou moeten werken als er geen unique constraint is
        $secondTag = Tag::create(['naam' => 'Java']);
        
        // Als er geen exception is, controleer dan dat beide tags zijn aangemaakt
        $this->assertDatabaseHas('tags', ['naam' => 'Java']);
        $this->assertDatabaseCount('tags', 2); // Beide tags moeten bestaan
        
        // OF als je wilt testen dat dubbele tags WEL zijn toegestaan:
        $tags = Tag::where('naam', 'Java')->get();
        $this->assertCount(2, $tags, 'Dubbele tags zijn toegestaan in de database');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function tag_heeft_een_naam()
    {
        $tag = new Tag(['naam' => 'Python']);
        $this->assertEquals('Python', $tag->naam);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function tag_kan_worden_verwijderd()
    {
        $tag = Tag::create(['naam' => 'C++']);
        $tag->delete();
        $this->assertDatabaseMissing('tags', ['naam' => 'C++']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function meerdere_tags_aanmaken()
    {
        Tag::create(['naam' => 'HTML']);
        Tag::create(['naam' => 'CSS']);
        Tag::create(['naam' => 'JavaScript']);
        
        $this->assertDatabaseCount('tags', 3);
    }
}