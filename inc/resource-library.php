<?php
/**
 * The resource library (the Speaking Resources page): everything Don has written, made
 * or recorded for clients, in one place and by category.
 *
 * Each item becomes a download by itself once its file is in assets/docs/library/,
 * named after it (e.g. "Hiring Checklist" → library/hiring-checklist.pdf). Audio is an
 * .mp3 the same way. Videos and web tools take a 'url'. Until there's a file or a link,
 * the item asks for a copy through the Speaking contact page instead.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The two interactive web tools, shown as cards above the library
 *
 * Each: name, line, icon (24x24 SVG insides), url ('' until the tool is live).
 *
 * @return array
 */
function donphin_resource_tools() {
	return array(
		array(
			'name' => 'Employee Turnover Cost Calculator',
			'line' => 'Put a number on what it costs every time someone walks out the door.',
			'icon' => '<rect x="4" y="2" width="16" height="20" rx="2"/><line x1="8" y1="6" x2="16" y2="6"/><line x1="8" y1="11" x2="8" y2="11.01"/><line x1="12" y1="11" x2="12" y2="11.01"/><line x1="16" y1="11" x2="16" y2="11.01"/><line x1="8" y1="15" x2="8" y2="15.01"/><line x1="12" y1="15" x2="12" y2="15.01"/><line x1="16" y1="15" x2="16" y2="18"/><line x1="8" y1="18" x2="12" y2="18"/>',
			'url'  => '',
		),
		array(
			'name' => 'Engagement & Retention Program Planner',
			'line' => 'Build the program that keeps your best people, one step at a time.',
			'icon' => '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="m9 16 2 2 4-4"/>',
			'url'  => '',
		),
	);
}

/**
 * The library, by category
 *
 * A category: title, chip (its short name, on the filter buttons), line, icon (24x24 SVG
 * insides), and items. Optional: 'ext' (the
 * file type its items are, 'pdf' by default; '' for link-only, like videos) and 'verb'
 * (the action on a link: 'Watch', 'Open').
 * An item is its name, or an array with 'name' plus any of: 'tag' (a small label, e.g.
 * "Audio"), 'ext', 'slug' (the file name, when the name won't do), 'url'.
 *
 * @return array
 */
function donphin_resource_library() {
	return array(
		'books'      => array(
			'title' => 'Books & Excerpts',
			'chip'  => 'Books',
			'line'  => 'Don’s books, workbooks and excerpts, to read cover to cover or dip into.',
			'icon'  => '<path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/>',
			'items' => array(
				array(
					'name' => 'The 40//40 Solution — Mastering Emotional Energy in Leadership and Sales',
					'tag'  => 'Full PDF',
					'slug' => 'the-40-40-solution',
				),
				array(
					'name' => 'The 40//40 Solution in Sales',
					'tag'  => 'Excerpt · PDF',
				),
				array(
					'name' => 'The 40//40 Solution in Sales',
					'tag'  => 'Excerpt · Audio',
					'ext'  => 'mp3',
				),
				array(
					'name' => 'The 40//40 Solution on Amazon',
					'tag'  => 'Audio · Kindle · Hardcover',
					'url'  => home_url( '/speaking/purchase-the-40-40-solution/' ),
				),
				'A to Z of Work Ideas and Questions',
				'Bathroom Book of Time',
				'From Chaos to Order',
				'The Great Job Opportunity',
				'Mastering Time Management',
				'The Truth About HR and You',
				'Visionaries Workbook – Learn from the Masters',
			),
		),
		'summaries'  => array(
			'title' => 'Book Summaries',
			'chip'  => 'Summaries',
			'line'  => 'The ideas Don returns to, distilled.',
			'icon'  => '<path d="M2 4h6a4 4 0 0 1 4 4v13a3 3 0 0 0-3-3H2z"/><path d="M22 4h-6a4 4 0 0 0-4 4v13a3 3 0 0 1 3-3h7z"/>',
			'items' => array(
				array(
					'name' => 'The Effective Executive',
					'tag'  => 'Peter Drucker',
				),
				array(
					'name' => 'Mastery',
					'tag'  => 'George Leonard',
				),
				array(
					'name' => 'Antifragile',
					'tag'  => 'Nassim Nicholas Taleb',
				),
			),
		),
		'forms'      => array(
			'title' => 'HR & Workplace Forms',
			'chip'  => 'Forms',
			'line'  => 'Ready-to-use forms and tools for the everyday work of managing people.',
			'icon'  => '<path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="13" y2="17"/>',
			'items' => array(
				'Candidate Referral Form',
				'Employee Correction Form',
				'Employee Suggestion Form',
				'Entrance Interview Form',
				'Got a Minute Pad',
				'Here’s Why I Deserve a Raise',
				'Investigator’s Tools',
				'OKR Template',
				'Prioritization Summary Form',
				'Retention Program Possibilities',
				'Stay Interview Questions',
				'The True Cost of Your HR Practices',
				'Time Sheet Process Improvement',
				'Total Compensation Paid by Company',
				'Weekly Time Sheet',
				'Video Conferencing Guide',
			),
		),
		'checklists' => array(
			'title' => 'HR & Management Checklists',
			'chip'  => 'Checklists',
			'line'  => 'Step by step, from the first interview to the last day — and everything between.',
			'icon'  => '<rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/>',
			'items' => array(
				'10 Steps to Getting a Raise',
				'48 Ideas for Creating A Secure Workplace',
				'60-Day New Employee Survey',
				'65 Powerful Strategies for Great HR',
				'90-Day Strategic Plan',
				'A Dozen Ways to Show Employees You Care',
				'AI Ethics and Compliance Policy for Human Resources',
				'Areas Where HR Can Apply Some Creativity',
				'Behavioral Interviewing',
				'Checklist for Conducting Online Investigations',
				'Checklist of Factors to Consider When Creating Sales Commission Agreements',
				'Checklist for Gamification',
				'Checklist for Great Office Design',
				'Checklist for Preventing Mistakes',
				'Community Involvement Checklist',
				'Company Culture is the Story We Tell Ourselves… About Ourselves',
				'Compensation Philosophy?',
				'Creating a Fun Workplace',
				'Creating an Employee Handbook',
				'Creativity Checklist',
				'Employee Onboarding Checklist',
				'Employee Referral Program (ERP) Checklist',
				'Employee Suggestion for Creating Fun and Engaging Activities',
				'Hiring Checklist',
				'HR Department Opportunity Survey',
				'Independent Contractor Checklist',
				'Investigating, Managing, and Preventing Wrongful Employee Conduct',
				'Just What is Company Culture Anyway?',
				'Managing Poor Performance Checklist',
				'Mental Health at Work: Strategies to Remain Caring, Productive, and Compliant',
				'Nepotism: The Pitfalls and Challenges',
				'Our Hiring Process FAQ',
				'Pre-termination Checklist',
				'Protecting Confidential Information Checklist',
				'Referral Bonus Program',
				'Remote Worker Risk Management Checklist',
				'Reward and Recognition Possibilities',
				'Sales Commission Agreements',
				'Seven Commandments of Social Media Use',
				'Training that Works Checklist',
				'Workplaces of the Future Checklist',
			),
		),
		'leadership' => array(
			'title' => 'Leadership, Mindset & Executive Performance',
			'chip'  => 'Leadership',
			'line'  => 'For the person in charge: energy, listening, time, and the stories that run it all.',
			'icon'  => '<path d="M12 2a7 7 0 0 0-4 12.7V17h8v-2.3A7 7 0 0 0 12 2z"/><line x1="9" y1="21" x2="15" y2="21"/>',
			'items' => array(
				'4 Phases of Emotional Development',
				'10 Things You Can Do to Have a Great Flying Experience',
				'15 Ideas for Better Time Management',
				'17 Blockages to Being a Great Executive',
				'17 Virtues of the Great Executive',
				'32 Things You Can Do to Be a Better Person',
				'50 Things You Can Do to Nurture and Balance Your Emotional Energy',
				'A Few Lessons Learned…',
				'Advice for Young People Looking to Decide on a Career Path',
				'An Exercise for Great Listening',
				'Assessing Your Leadership Quotient',
				'Balanced Life Checkup',
				'Being Safe at Work, Home, and on the Road',
				'Career Strategies – What’s Next for Your Career?',
				'Getting to Know You',
				'Golden Rules For Being Successful At Work',
				'How to be an Excellent Employee',
				'Inspiring Quotes',
				'Managing the Crazy Changes Coming Your Way',
				'Preparedness 101: Zombie Pandemic',
				'Powerful Presentation Techniques',
				'Powerful Thoughts from RIGHT NOW',
				'Revisiting Maslow’s Hierarchy of Needs',
				'Seven Steps to Up Your Speaking Game',
				'Show We Care',
				'Spiritual Wisdom',
				'Strategies for Developing a Career Path that Works',
				'The Five-Minute Listening Exercise',
				'Vision, Mission, Values, and Goals Worksheet',
				'Visualization Techniques for Success',
				'Wellness Opportunity… Where Do We Go From Here?',
				'Writing and Speaking Ideas Checklist',
				'Your Health is Wealth Shopping Checklist',
			),
		),
		'coaching'   => array(
			'title' => 'Coaching Worksheets',
			'chip'  => 'Coaching',
			'line'  => 'Before, during and after the session.',
			'icon'  => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
			'items' => array(
				'Coaching Questions',
				'Coaching Session Preparation',
				'Timeline of a Coaching Session',
				'Coachable Moments Checklist',
				'How to Hire Your First Coach',
			),
		),
		'posters'    => array(
			'title' => 'Posters & Printables',
			'chip'  => 'Posters',
			'line'  => 'For the break room wall.',
			'icon'  => '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.1-3.1a2 2 0 0 0-2.8 0L6 21"/>',
			'items' => array(
				'Coaching Poster',
				'Great Employees Poster',
				'Great Manager Poster',
				'HR Poster',
				'Spirit at Work – Blue',
				'Spirit at Work – Red',
				'Workshop Poster',
			),
		),
		'videos'     => array(
			'title' => 'Videos & Lessons',
			'chip'  => 'Videos',
			'line'  => 'Don on camera: leadership lessons and talks.',
			'icon'  => '<circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/>',
			'ext'   => '',
			'verb'  => 'Watch',
			'items' => array(
				array(
					'name' => 'Control to Engagement',
					'tag'  => 'Leadership Training · Lesson 1',
				),
				array(
					'name' => 'The Way Out is Going In: Control to Engagement',
					'tag'  => 'Lesson 2',
				),
				array(
					'name' => 'Managing Your Emotional Energy',
					'tag'  => 'Leadership Training · Lesson 3',
				),
				'Management’s Responsibility to Employees',
				'The HR Opportunity for the Non-HR Executive',
				'The Inspired Workforce',
				'The 40//40 Solution: Mastering Emotional Energy in Leadership and Sales',
				'Coax, Encourage, Inspire',
				'You Are a Miracle',
			),
		),
	);
}

/**
 * One library item, ready to show: name, tag, href, action ('Download', 'Listen',
 * 'Watch', 'Open' or 'Request') and whether it's a file to download
 *
 * @param string|array $item        The item, as in donphin_resource_library().
 * @param array        $category    Its category.
 * @param string       $contact_url Where requests go.
 * @return array
 */
function donphin_resource_item( $item, $category, $contact_url ) {
	$item = is_array( $item ) ? $item : array( 'name' => $item );
	$ext  = isset( $item['ext'] ) ? $item['ext'] : ( isset( $category['ext'] ) ? $category['ext'] : 'pdf' );
	$slug = isset( $item['slug'] ) ? $item['slug'] : sanitize_title( $item['name'] );

	$out = array(
		'name'     => $item['name'],
		'tag'      => isset( $item['tag'] ) ? $item['tag'] : '',
		'href'     => '',
		'action'   => '',
		'download' => false,
	);

	// A file in the library folder comes first
	if ( '' !== $ext ) {
		$path = '/assets/docs/library/' . $slug . '.' . $ext;
		if ( file_exists( get_stylesheet_directory() . $path ) ) {
			$out['href']     = get_stylesheet_directory_uri() . $path;
			$out['action']   = 'mp3' === $ext ? 'Listen' : 'Download';
			$out['download'] = 'mp3' !== $ext;
		}
	}

	// Then a link (a video, a web tool, a page)
	if ( '' === $out['href'] && ! empty( $item['url'] ) ) {
		$out['href']   = $item['url'];
		$out['action'] = isset( $category['verb'] ) ? $category['verb'] : 'Open';
	}

	// Otherwise ask for it, naming it so the contact form can fill in the message
	if ( '' === $out['href'] ) {
		$label         = $out['name'] . ( '' !== $out['tag'] ? ' (' . $out['tag'] . ')' : '' );
		$out['href']   = add_query_arg( 'resource', rawurlencode( $label ), $contact_url );
		$out['action'] = 'Request';
	}

	return $out;
}
