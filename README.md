# Web Programming (IT 413)

A collection of assignments from a web programming course, progressing from static HTML pages through client-side scripting, CSS frameworks, server-side languages (C#/ASP.NET, PHP), and a final full-stack project with a database-backed REST-style API and Facebook login integration.

## Structure

<dl>
<dt><strong>Week 1: Simple Page</strong></dt>
<dd>A single static HTML page (a recipe page) covering basic HTML structure, tables, lists, and images.</dd>

<dt><strong>Week 2: Simple Website</strong></dt>
<dd>A multi-page static business website (home, about, team, services, contact) with a shared navigation bar, an image gallery, embedded video, and a linked external stylesheet.</dd>

<dt><strong>Week 3: JavaScript</strong></dt>
<dd>Client-side form validation added to the Week 2 site - a contact form is checked with vanilla JavaScript for required fields and length constraints before submission, with error messages shown via alert.</dd>

<dt><strong>Week 3: jQuery</strong></dt>
<dd>A standalone page demonstrating core jQuery DOM manipulation: fading elements out, dynamically changing text and CSS properties, and appending new elements to the page in response to button clicks.</dd>

<dt><strong>Week 4: Bootstrap</strong></dt>
<dd>The business website rebuilt using Bootstrap 5 - a responsive navbar with a collapsible mobile menu, a Bootstrap-based image gallery, and updated layout/styling components in place of the raw HTML tables from Week 2.</dd>

<dt><strong>Week 5: C# (ASP.NET Razor Pages)</strong></dt>
<dd>A Razor Pages contact form built in C#/.NET 5. Server-side form handling validates name length, character restrictions, address length, and phone number format on POST, then renders a Bootstrap success or error alert back on the same page.</dd>

<dt><strong>Week 6: PHP Forms</strong></dt>
<dd>The same contact form and validation logic reimplemented in PHP, with the validation functions separated into their own file and included into the form page.</dd>

<dt><strong>Week 6: PHP Image Processing</strong></dt>
<dd>A PHP class that resizes a JPEG image to a fixed width while preserving aspect ratio, using the GD image library, and outputs the result as a new file.</dd>

<dt><strong>Week 6: PHP & XML</strong></dt>
<dd>A PHP class that parses an XML data source (a CD catalog) and transforms it using an XSL stylesheet, then outputs the result.</dd>

<dt><strong>Weeks 8-10: Final Project - Project Task Tracker</strong></dt>
<dd>A full-stack project/task tracking app. A PHP backend (using mysqli with prepared statements) exposes a small JSON API for logging in, listing projects, and listing tasks by project from a MySQL database. The jQuery/Bootstrap front end lets a logged-in user select a project, view its tasks in a table, and add or edit tasks through modal dialogs, with dynamic UI updates driven entirely by AJAX calls to the PHP API. Also includes Facebook Login integration as an alternate authentication method.</dd>
</dl>

## Tech Stack
- HTML
- CSS
- JavaScript
- jQuery
- Bootstrap 5
- C# / ASP.NET Razor Pages (.NET 5)
- PHP
- MySQL (mysqli)
- XML/XSLT
