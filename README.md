<p align="center">
  <a href="http://knowyourschoolproject.org/">
    <img src="http://t1d1c3a5206317oh1he0bx14.wpengine.netdna-cdn.com/wp-content/uploads/2016/06/excel_in_ed-logo.png" width=150 height=143>
  </a>

  <h3 align="center"><a href="http://knowyourschoolproject.org/">Know Your School Project</a></h3>

  <p align="center">
    The Know Your School online report card tool is a prototype of a reimagined, transparent, online school report card for states. It is intentionally designed as a base for a state, with the capability of expansion over time. The Know Your School tool was built using open-source front-end code that is accessible free of charge as a resource for other developers. Implementation of the code will require modification for new data sources.
  </p>
</p>

<br>

## Table of contents

- [About The Guide](#about-the-guide)
- [What's included](#whats-included)
- [Overview of Features](#overview-of-features)
- [Overview of Limitations or Bugs](#overview-of-limitations-or-bugs)
- [Documentation](#documentation)
- [Creators](#creators)
- [Acknowledgements](#acknowledgements)
- [Copyright and License](#copyright-and-license)
- [For Education Stakeholders](#for-education-stakeholders)



## About The Guide

This guide will focus deployment of the codebase, and is geared toward developers.



## What's Included

Within the download you'll find the following directories and files, logically grouping common assets and providing both compiled and minified variations. You'll see something like this:

```
knowyourfloriaschool-child/
├── js/
│   ├── school-reportcards.js
│   ├── scripts.js
│   ├── scripts.min.js
│   └── search.js
└── template-parts/
    └── page/
        ├── florida-schoolreportcard/
        │   ├── functions.php
        │   ├── grade-components/..
        │   ├── overview/..
        │   ├── performance-details/..
        │   └── school-characteristics/..
        ├── florida-schoolreportcard.php
        │
        ├── florida-schoolscompare/
        │   └── school-cards.php
        ├── florida-schoolscompare.php
        │
        ├── search/
        │   ├── excelined-feed.php
        │   └── excelined-filters.php
        ├── search.php
        │
        └── settings/
            └── variables.php
```



## Overview of Features

- Dynamic search, sort and filtering by district, address and name
- Advanced search and filtering by school grade component
- Side-by-side comparison feature for up to five schools
- School level report cards for thousands of schools
- Parent empowerment statements that provide human-friendly context and next steps based on relative performance scores 
- Consolidated state level report of critical metrics



## Overview of Limitations or Bugs

**API**

The Know Your School online report card tool uses an API that was built by <a href="http://www.jaxpef.org/">JaxPEF</a> and <a href="http://www.discovertec.com/">DiscoverTec</a>. Licensing of this API prevents us from being able to share credentials necessary to access the API's data. On line 3 of "knowyourfloriaschool-child/template-parts/page/settings/variables.php" you will see the text "API_SECURITY_KEY" where we have removed this key. Please review the files outlined in <a href="#whats-included">What's Included</a> to get a better understanding of this integration.

**Images**

Some images may not be available.



## Documentation

The Know Your School online report card tool was built in <a href="https://wordpress.org/">WordPress</a>, in a child theme of <a href="http://cardinal.swiftideas.com/">Cardinal</a>.

### Running Locally Using <a href="https://www.mamp.info/">MAMP</a>

1. Learn more about setting up a local WordPress install by reviewing their <a href="https://codex.wordpress.org/Installing_WordPress_Locally_on_Your_Mac_With_MAMP">documentation</a>.
2. Install and activate <a href="#required-theme-and-plugins">required theme and plugins</a>.
3. <a href="https://github.com/jmstovall/KnowYourSchoolProject/archive/master.zip">Download the latest version</a> of /knowyourfloriaschool-child and place it in the theme folder. (Example ./wp-content/themes/knowyourfloriaschool-child)
4. Import the database.sql file into your local environment using <a href="http://localhost:8888/phpMyAdmin/">phpMyAdmin</a>.
5. Go to http://localhost:8888/ to view the tool locally.

### Required Theme and Plugins

**Theme**

- <a href="http://cardinal.swiftideas.com/">Cardinal</a>

**Plugins**

- <a href="https://wordpress.org/plugins/advanced-custom-fields/">Advanced Custom Fields</a>
- <a href="https://www.advancedcustomfields.com/add-ons/repeater-field/">Advanced Custom Fields: Repeater Field</a>
- <a href="https://wordpress.org/plugins/breadcrumb-navxt/">Breadcrumb NavXT</a>
- <a href="http://swiftideas.com/extras/plugins/swift-framework.zip"> Swift Framework</a>

### Implement API

1. See <a href="#whats-included">What's Included</a> for a list of all files that are associate with the API. Comments in the code of those files can further explain the API's existing integration.
2. From the root /knowyourfloriaschool-child directory, run <code>grunt</code> in the command line to rebuild distributed CSS and JavaScript files.



## Creators

**ExcelinEd**

<a href="http://www.excelined.org/">ExcelinEd</a> is the sponsoring organization behind the project through which it is continuing to support state efforts to participate in rulemaking and implementation of ESSA and preserve rigorous standards and assessments and strong accountability systems.

**Collaborative Communications**

<a href="http://collaborativecommunications.com/">Collaborative Communications</a> provides unmatched knowledge and understanding of the end users of the tool and manages overall project delivery, leveraging related experience in public reporting projects for states in DC and Illinois, as well as with Data Quality Campaign and the Southern Regional Education Board (SREB).

**Social Driver**

<a href="https://socialdriver.com/">Social Driver</a> leads the technology and design of the project, including the  strategic thinking behind how other states can adapt the tool. Social Driver lead the website’s user experience and shareability features. Social Driver concepted Know Your Florida School’s mobile-first approach — and helped architect several enhancements to the API. 



## Acknowledgements

**JaxPEF**

<a href="http://www.jaxpef.org/">JaxPEF</a> serves as an on-the-ground partner with a deep and rich understanding of local communities and maintains an agreement with Florida to access state education data.

**DiscoverTec**

<a href="http://www.discovertec.com/">DiscoverTec</a> is a Jacksonville, Florida based web design, hosting and marketing firm. We assist clients create an internet presence, from site design and creation to marketing.



## Copyright and License

Code and documentation copyright 2015-2017 Social Driver and/or Collaborative Communications.  As a derivative work of WordPress, under the WordPress licensing we follow the terms of the GPL version 2 or (at your option) any later version. See https://github.com/WordPress/WordPress/blob/master/license.txt for more information. Documentation is released under Creative Commons.



## For Education Stakeholders

**Overview**

In recognition of the limitations of current state public school accountability reports, the Foundation for Excellence in Education (ExcelinEd) sponsored the My School Information Design Challenge in December 2014 to reimagine the public reporting of school accountability data. Following that competition, ExcelinEd brought the design challenge to life with the winners, Collaborative Communications and Social Driver, as well as community data partner Jacksonville Public Education Fund (JaxPEF).
 
These partners developed and launched Know Your Florida School, an exemplar online school report card tool featuring data from the state of Florida. Know Your Florida School’s engaging, mobile-friendly interface puts information about local schools—from student performance to the details of Florida’s school grades—into context to help parents access and use the data.
 
In alignment with ExcelinEd’s mission to support states in their efforts to put student success at the core of the education reform agenda, the tool is built using an open source development process. While the tool features a sampling of actual data components, the framework presented here is designed to provide states with a head start to own a public reporting tool that reflects their priorities and the breadth of their school data.

**Goals**

The My School Information Design Challenge built upon research from the Education Commission of the States, which found that parents want school report cards that illustrate comparisons between schools and the rest of the state. To contextualize school performance and growth data and to inspire engagement with school leaders, the tool also includes parent empowerment statements alongside the data. These statements are driven by the data and offer a starting point for conversations with their school’s principals about school accountability metrics that include: high school graduation rate, performance on state assessments, and even school climate.

**More Information**

This guide is for developers. To learn more about the project’s impact, download the issue brief series and access resources for SEAs, visit https://knowyourfloridaschool.org/about/.
