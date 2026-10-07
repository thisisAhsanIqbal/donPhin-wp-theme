<?php
/**
 * The starter resources, imported once from Speaking Resources > Import (see
 * inc/resources-admin.php). Loaded only for the import; after it, the resources are
 * managed in the admin and this list is just a record of where they started.
 *
 * @package DonPhinEsq
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The Speaking library as it was first gathered, by category, for the one-time import
 *
 * A category: title, chip (its short name, on the filter buttons), line, icon (a key of
 * donphin_resource_icons()), and items. An item is its title, or an array with 'name'
 * plus 'tag' (a small label) and 'url' (a link, as a path on this site or a full address).
 *
 * @return array
 */
function donphin_resources_seed_speaking() {
	return array(
		'books'      => array(
			'title' => 'Books & Excerpts',
			'chip'  => 'Books',
			'line'  => 'Don’s books, workbooks and excerpts, to read cover to cover or dip into.',
			'icon'  => 'book',
			'items' => array(
				array(
					'name' => 'The 40//40 Solution — Mastering Emotional Energy in Leadership and Sales',
					'tag'  => 'Full PDF',
				),
				array(
					'name' => 'The 40//40 Solution in Sales',
					'tag'  => 'Excerpt · PDF',
				),
				array(
					'name' => 'The 40//40 Solution in Sales (Audio)',
					'tag'  => 'Excerpt · Audio',
				),
				array(
					'name' => 'The 40//40 Solution on Amazon',
					'tag'  => 'Audio · Kindle · Hardcover',
					'url'  => '/speaking/purchase-the-40-40-solution/',
				),
				'A to Z of Work Ideas and Questions',
				'Bathroom Book of Time',
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
			'icon'  => 'open-book',
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
			'icon'  => 'form',
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
			'icon'  => 'checklist',
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
			'icon'  => 'idea',
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
			'icon'  => 'chat',
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
			'icon'  => 'image',
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
			'icon'  => 'play',
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
