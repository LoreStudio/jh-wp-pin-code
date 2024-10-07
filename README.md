# jh-wp-pin-code

This WordPress plugin allows website managers to add a pin or password to protect either the full site or specific pages.

### Usage Instructions
 - Upload the plugin zip file and activate.
 - Go to the PIN Code Login page from your WordPress dashboard.
 - Update any settings for the appearance of the PIN popup modal.
 - At the bottom, add pins for site wide or page specific protection. Be sure to click "Add" for page specific PINs, and also then save the page settings as a whole.

### Additional Background on Implementation

There are notable challenges to loading password protected pages on web hosts with strong caching. This has been particularly notable on WP Engine. See this page for details on WPEngine's caching approach: (https://wpengine.com/support/cache/)[https://wpengine.com/support/cache/].

The plugin implements a variety of methods to get around this caching, including setting no-cache PHP headers, adding cookies as suggested by WPEngine documentation, and adding a dynamic/random query parameters on each page load for pin-protected pages. Even with all these measures, it seems that WPEngine caching sometimes forces users to re-enter pins when revisting the page.

In an earlier version, we attempted to get around the caching issue by shifting from cookie based password protection to the database storage approach you will see in the plugin now. However, the database appraoch had limited effectiveness in circumventing WPEngine server-side caching. So in the future, we can refactor this back to traditional cookie-based approach to managing access, and rely on the other cache-busting methods above.

