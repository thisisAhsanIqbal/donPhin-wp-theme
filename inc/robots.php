<?php
/**
 * robots.txt: let AI assistants read the site, even while search engines are kept out
 *
 * While "Discourage search engines from indexing this site" is ticked (Settings >
 * Reading, as it should be on a development site), WordPress answers every crawler
 * with "Disallow: /". That also stops AI assistants reading the site when someone asks
 * one to look at it. This adds a group for each AI reader that allows them in; each
 * crawler follows the group that names it most specifically, so these override the
 * general rule for them alone, and search engines stay out.
 *
 * On the public site nothing is blocked to begin with, so this changes nothing there.
 * Pages also carry "noindex", which keeps them out of search results but doesn't stop
 * anyone reading them, so it is left as it is.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The AI assistants and crawlers allowed to read the site, by the name they send
 *
 * @return array
 */
function donphin_ai_readers() {
	return array(
		// Anthropic (Claude)
		'ClaudeBot',
		'Claude-User',
		'Claude-SearchBot',
		// OpenAI (ChatGPT)
		'GPTBot',
		'ChatGPT-User',
		'OAI-SearchBot',
		// Perplexity
		'PerplexityBot',
		'Perplexity-User',
		// Google's AI (Gemini); not Google Search, which stays blocked while the site is private
		'Google-Extended',
		// Microsoft Copilot, Meta AI, Mistral
		'CopilotBot',
		'meta-externalagent',
		'MistralAI-User',
	);
}

/**
 * Put the AI readers' groups in front of WordPress's own rules
 *
 * @param string $output The robots.txt WordPress would send.
 * @param bool   $public Whether search engines are allowed (Settings > Reading).
 * @return string
 */
function donphin_robots_txt( $output, $public ) {
	if ( $public ) {
		return $output;
	}

	$groups = '';
	foreach ( donphin_ai_readers() as $agent ) {
		$groups .= 'User-agent: ' . $agent . "\n";
	}
	$groups .= "Allow: /\n\n";

	return "# AI assistants may read this site; search engines may not while it is in development\n" . $groups . $output;
}
add_filter( 'robots_txt', 'donphin_robots_txt', 10, 2 );
