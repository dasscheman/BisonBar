<?php

/*
|--------------------------------------------------------------------------
| Public pages
|--------------------------------------------------------------------------
|
| Google verifies the OAuth consent screen by crawling the home page and the
| privacy policy. These tests lock in the properties that verification needs:
| both pages are reachable without a session, they are distinct URLs, the home
| page names the app and links to the privacy policy, and the privacy policy
| carries enough content.
|
*/

beforeEach(function () {
    $this->withoutVite();
});

it('serves the home page without a session', function () {
    $this->get('/info')
        ->assertOk()
        ->assertSee(config('app.name'));
});

it('serves the privacy policy without a session', function () {
    $this->get('/privacy')
        ->assertOk()
        ->assertSee(__('Privacybeleid'));
});

it('keeps the home page and the privacy policy on separate urls', function () {
    expect(route('info'))->not->toBe(route('privacy'));
});

it('links the home page to the privacy policy', function () {
    $this->get('/info')
        ->assertOk()
        ->assertSee(route('privacy'), false);
});

it('gives the home page and the privacy policy a distinct title', function () {
    $this->get('/info')->assertSee('<title>'.config('app.name').'</title>', false);
    $this->get('/privacy')->assertSee('<title>Privacybeleid | '.config('app.name').'</title>', false);
});

it('explains the purpose of the app on the home page', function () {
    $this->get('/info')
        ->assertOk()
        ->assertSee(__('Waarvoor dient BisonBar?'))
        ->assertSee(config('bisonbar.organisation'));
});

it('details data collection and usage in the privacy policy', function () {
    $response = $this->get('/privacy')->assertOk();

    $response->assertSee(__('Welke gegevens verwerken wij?'))
        ->assertSee(__('Op welke grondslag?'))
        ->assertSee(__('Bewaartermijnen'))
        ->assertSee(__('Jouw rechten'))
        ->assertSee(__('Met wie delen wij gegevens?'));

    $text = trim(preg_replace('/\s+/', ' ', strip_tags($response->getContent())));

    expect(str_word_count($text))->toBeGreaterThan(400);
});

it('documents the requested google scope on both public pages', function () {
    $this->get('/info')->assertOk()->assertSee('gmail.send', false);
    $this->get('/privacy')->assertOk()->assertSee('gmail.send', false);
});

it('renders the site verification tag when one is configured', function () {
    config(['bisonbar.google_site_verification' => 'test-token']);

    $this->get('/info')
        ->assertOk()
        ->assertSee('<meta name="google-site-verification" content="test-token">', false);
});

it('omits the site verification tag when none is configured', function () {
    config(['bisonbar.google_site_verification' => null]);

    $this->get('/info')
        ->assertOk()
        ->assertDontSee('google-site-verification', false);
});

it('serves the privacy policy under the legacy alias too', function () {
    $this->get('/privacy-policy')->assertOk();
});

it('lists the public pages in the sitemap', function () {
    $response = $this->get('/sitemap.xml')->assertOk();

    expect($response->headers->get('content-type'))->toContain('xml');

    $response->assertSee(route('info'), false)
        ->assertSee(route('privacy'), false);
});
