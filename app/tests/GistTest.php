<?php

class GistTest extends TestCase
{
    public function testGetListOfCountedTags()
    {
        $gist1 = new Gist();
        $gist1->setDescriptionAndTags('description #BBB_tag #ddd_tag #aaa10_tag');
        $gist1->setPublic(false);
        $gist1->setOwner(['id' => 0]);
        $gist1->setStarred(false);

        $gist2 = new Gist();
        $gist2->setDescriptionAndTags('description #BBB_tag #ddd_tag #aaa2_tag');
        $gist2->setPublic(false);
        $gist2->setOwner(['id' => 0]);
        $gist2->setStarred(false);

        $gist3 = new Gist();
        $gist3->setDescriptionAndTags('description #aaa1_tag #ccc_tag');
        $gist3->setPublic(false);
        $gist3->setOwner(['id' => 0]);
        $gist3->setStarred(true);

        $gist4 = new Gist();
        $gist4->setDescriptionAndTags('description');
        $gist4->setPublic(true);
        $gist4->setOwner(['id' => 1]);
        $gist4->setStarred(true);

        $gist5 = new Gist();
        $gist5->setDescriptionAndTags('description');
        $gist5->setPublic(true);
        $gist5->setOwner(['id' => null]);
        $gist5->setStarred(true);

        $gists = [$gist1, $gist2, $gist3, $gist4, $gist5];

        $gistCounter = new GistCounter($gists, 0);

        $this->assertEquals(2, $gistCounter->getPublic());
        $this->assertEquals(3, $gistCounter->getPrivate());
        $this->assertEquals(2, $gistCounter->getWithoutTag());
        $this->assertEquals(5, $gistCounter->getAll());
        $this->assertEquals(3, $gistCounter->getOwned());
        $this->assertEquals(3, $gistCounter->getStarred());
        $this->assertEquals(
            [
                0 => [
                    'name'  => '#aaa1_tag',
                    'count' => 1
                ],
                1 => [
                    'name'  => '#aaa2_tag',
                    'count' => 1
                ],
                2 => [
                    'name'  => '#aaa10_tag',
                    'count' => 1
                ],
                3 => [
                    'name'  => '#BBB_tag',
                    'count' => 2
                ],
                4 => [
                    'name'  => '#ccc_tag',
                    'count' => 1
                ],
                5 => [
                    'name'  => '#ddd_tag',
                    'count' => 2
                ]
            ],
            $gistCounter->getTags()
        );
    }

    public function testGetListOfCountedTagsWhenThereAreNoGists()
    {
        $gists = [];

        $gistCounter = new GistCounter($gists, 0);

        $this->assertEquals(0, $gistCounter->getPublic());
        $this->assertEquals(0, $gistCounter->getPrivate());
        $this->assertEquals(0, $gistCounter->getWithoutTag());
        $this->assertEquals(0, $gistCounter->getAll());
        $this->assertEquals(0, $gistCounter->getOwned());
        $this->assertEquals(0, $gistCounter->getStarred());
        $this->assertEquals([], $gistCounter->getTags());
    }
}
