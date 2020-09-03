# Front End Submission

## How to use front end form and basic feature documentation:
1. The plugin shortcode `[display_fe_form]` can be used to display the form on the front end.
2. The form as of now has five fields. ( Post title, Post type, Post content, Post excerpt and Post image ).
3. All of the 5 fields are mandatory and an error message will be shown on the respective field if left empty.
4. If all the fields are filled properly it will save it as the respective post type and upload the feature image.
5. Then an email will be sent to the site admin for the review.

## How to use front end post list shortcode and basic feature documentation:
1. The plugin shortcode `[display_fe_post_list]` can be used to display the post lists submitted via the plugin's front end form.
2. The post lists are shown to the admin. The author who can also see the posts using this shortcode but the shortcode will only show the posts that have been submitted by the author themself.
3. You can find the post title, author name and edit url with the shortcode.
4. Pagination will be shown if there are more than 10 posts but you can use `fes_post_per_page_list` to change that to fewer posts to test the pagination.
5. The posts are sorted by date in ascending order

