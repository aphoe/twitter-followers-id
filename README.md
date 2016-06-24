##About
This repository code is a *crude* script to get the **User IDs** of the followers of a twitter user. 

This code implements [Twitter API 1.1](https://dev.twitter.com/docs/api/1.1), as such you need to create [an app](https://apps.twitter.com/app/new) from your twitter account.

I have tried to comment my code as much as I should and I have used user-friendly variable names but sometimes... my brain thinks faster than my hands could type so some things are skipped ;)

##Instructions
1. Download the zipped file (or clone the repo) and extract to your web server.
2. open `follow.php` and do the following
  1. Add the username of the user whose follower you want to save
  2. Add your **Twitter App** values to lines 12-15
3. Run the script from your web browser via localhost or webserver.
4. The followers will be saved to a file in the `followers` folder. The naming format of the text file is `[username]_followers.txt`

##PHP Server info
Just in case the list of followers is quite high, you might have to change the `max_execution_time` config value in your **PHP Config** file ie php.ini to something meaningful.

I used a value of `43200` (12 hours) on my test server. Although no script I used during test took that long.

> Twitter only allows for 15 requests every 15minutes, so the script has to sleep for 15 minutes everytime the 15 request has been reached.

##Imported libraries
The project uses the [OAuth Library PHP scripts](http://oauth.net). and are available in the `lib` folder
