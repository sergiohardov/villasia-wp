# VillAsia Project Structure

The project is divided into two structures: **presentation - theme** and **core - plugin**. Each structure has its own gulpfile.js

**Plugin**: wp-content/plugins/ct-core

**Theme**: wp-content/themes/ct-theme

Before starting work on any part of the project, while in the root of the necessary structure, it is necessary to install packages:

```bash
npm install
```

After we have installed all the packages, to see the list of commands, it is necessary to execute:

```bash
npm run start
```

## Commands List

**Run Develop Mode** - It launches a watcher and page refresh, allowing real-time code editing and seeing the changes.  
**Run Build** - It gathers files from the source folder into the assets folder.  
**Compile Fonts** - If only fonts need to be updated, you can run the "Run Develop Mode" command in parallel.  
**Compile SVG** - If only svg need to be updated, you can run the "Run Develop Mode" command in parallel.  
**Compile Libs** - If only folder libs need to be updated, you can run the "Run Develop Mode" command in parallel.  

## Theme Structure

```
├── assets/... - The folder that is automatically generated using gulp based on tasks, with source files located in the source/ folder. Nothing can be manually added to it! If anything needs to be added to it, a corresponding task should be written in the gulpfile.js.  
├── inc/ - The folder contains the functional logic of the theme.  
│ ├── acf-fields/... - The folder that contains JSON files of ACF fields (https://www.advancedcustomfields.com/resources/local-json/) Which may be moved to the core plugin in the future.  
│ └── theme/... - Contains files that are included in the main theme file functions.php.  
├── languages/... - Default wp codex.  
├── node_modules/... - Default node codex.  
├── sources/ - Folder source files compiled by gulp.  
│ ├── fonts/... - Folder for fonts, including in wp-content/themes/ct-theme/sources/scss/_fonts.scss. 
│ ├── js/ - Folder for scripts.  
│ │ ├── components/... - Folder for scripts related to code snippets created in the template-parts/ folder, following the same strict naming convention as described in the template-parts folder description.  
│ │ ├── page/... - Folder for scripts related to code templates created in the template-pages/ folder, following the same strict naming convention as described in the template-pages folder description.  
│ │ └── script.js - Entry point for all scripts.  
│ ├── libs/ - The folder moves all contents without any modifications.  
│ ├── scss/ - Folder for styles.  
│ │ ├── components/... Folder for styles related to code snippets created in the template-parts/ folder, following the same strict naming convention as described in the template-parts folder description.  
│ │ ├── page/... - Folder for styles related to code templates created in the template-pages/ folder, following the same strict naming convention as described in the template-pages folder description.  
│ │ └── style.scss - Entry point for all styles.  
│ └── svg/... - Folder for icons, vector graphic.  
├── template-forms/... - Storing the working HTML from Contact Form 7 forms in case any changes made in the editor lead to code breaking.  
├── template-pages/... - Code templates for pages. When creating a new template, it's necessary to adhere to strict naming conventions to avoid class conflicts. If we are creating a Contact page, inside this folder, file such as contact.php should be created, and the parent class for the entire page should be ".page-contact". Then, subsequent elements should be added from it: ".page-contact__title" and so on.  
├── template-parts/... - Code snippets that can be considered as blocks or components. When creating a new block, it's essential to follow strict naming conventions to avoid class conflicts. If it logically makes sense to have multiple cards, such as a product card or a post card, then a folder named "card" should be created. Inside this folder, files such as product.php and post.php should be created. Within these files, parent classes for the block should be named according to the folder-file structure, such as ".card-post" and ".card-product".  
├── 404.php - Default wp codex.  
├── archive.php - Default wp codex.
├── category.php - Default wp codex.  
├── footer.php - Default wp codex. 
├── functions.php - Default wp codex.  
├── gulpfile.js - Theme gulpfile, all tasks here.  
├── header.php - Default wp codex.  
├── index.php - Default wp codex. 
├── package-lock.json - Default node codex.  
├── package.json - Default node codex.  
├── page.php - Default wp codex.  
├── screenshot.png - Default wp codex.  
├── search.php - Default wp codex.
├── single.php - Default wp codex.
└── style.css - Default wp codex.
```

## Plugin Structure

```
├── assets/... - The folder that is automatically generated using gulp based on tasks, with source files located in the source/ folder. Nothing can be manually added to it!!! If anything needs to be added to it, a corresponding task should be written in the gulpfile.js.
├── includes/ - The folder contains all the logic. The MVC pattern is used, following an Object-Oriented Programming (OOP) approach. An autoloader is connected to the folder.
│ ├── API/... - Some classes responsible for APIs or utility functions.
│ ├── Controller/... - Default MVC codex.
│ ├── Model/... - Default MVC codex.
│ ├── View/... - Default MVC codex.
│ └── ACF_Settings.php - Responsible for certain ACF settings, may be moved.
├── languages/... - Default wp codex.
├── node_modules/... - Default node codex.
├── sources/ - Folder source files compiled by gulp.
│ ├── js/ - Folder for scripts.
│ │ ├── ...
│ │ └── script.js - Entry point for all scripts.
│ └── scss/ - Folder for styles.
│ ├── ...
│ └── tyle.scss - Entry point for all styles.
├── templates/... - The plugin is built using the MVC pattern, as the VIEW has its own templates and logic. For convenience, the markup is placed in a separate folder.
├── vendor/... - Default composer codex.
├── composer.json - Default composer codex.
├── composer.lock - Default composer codex.
├── ct-core.php - Default wp codex.
├── gulpfile.js - Plugin gulpfile, all tasks here.
├── package-lock.json - Default node codex.
├── package.json - Default node codex.
└── uninstall.php - Default wp codex.
```

## Contributing

There's an automatic deployment setup from the GitHub rep. to our hosting.

If you want to make any changes please create brunches under your name for example: "artimon/your-branch"

If you want to share something with us please open an issue/discussion. DO NOT PUSH or MERGE anything into main branch.

For the review you can assign @sergiohardov

## Project Specification

**PHP**: _7.4.33_  
**WP**: _6.4.3_  
**Node**: _18.17.0_  

## Plugins Dependencies

**Advanced Custom Fields PRO**: _6.1.2_  
**ACF: Multiple Taxonomy**: _1.0.6_  
**Contact Form 7**: _5.8.4_  
**Contact Form CFDB7**: _1.2.6.7_  
**Yoast SEO**: _21.8_  
**Yoast Duplicate Post**: _4.5_  
