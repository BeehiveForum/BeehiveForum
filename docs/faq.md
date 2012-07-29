# Beehive Forum Frequently Asked Questions

Version 0.1 / 8th December 2002

## 0. Contents

1. About Beehive
    1. What is Beehive?
    2. Who wrote it?
    3. Why did you write it?
    4. Can I use Beehive on my own web site?
2. Installing Beehive and getting it to work
    1 Where to find installation instructions
3. Technical questions?
    1 How scalable is Beehive?
    2 Why did you write it in PHP?
4. Other questions
    1 Why the fixation with bees?
    2 I hate frames. Why did you use them?
5. Improving Beehive
    1 Beehive doesn't do x. Can you make it do that?
6. Trouble Shooting
    1 Database connectivity problems or permission denied errors
    2 Unknown or missing table errors
    3 Blank page errors
    4 Error: Strict Standards: var: Deprecated on PHP/5.x
    5 Email notifications on Windows.

## 1. About Beehive

### 1.1 What is Beehive?

Beehive is an online forum/message board system with several powerful 
features:
- Frames-based layout (OK, some people hate frames, but they really 
  are handy when you're using a forum like this)
- Per-user tracking of read and unread posts
- E-mail notification when someone posts a message to you
- Polls
- Attachments to posts
- Customisable colour schemes and styles
- The ability to ignore folders that do not interest you
- Restricted-access folders
- A comprehensive user administration system, including some 
  imaginative ways to ban persistent idiots (like the "Worm" 
  mode, where the idiot in question thinks things are going
  on as normal but all his posts show as deleted to other 
  users), and the ability to elect moderators to run the forum
- Fully customisable user profiles
- A powerful search facility

### 1.2 Who wrote it?

Beehive has been written by several members of what is now called 
"Teh Forum", which can be found at http://www.tehforum.co.uk/forum/. 
A full list of credits appears in readme.txt.

### 1.3 Why did you write it?

Until mid-2002, we were a (reasonably) happy community on Delphi 
Forums - the ads were a bit irritating, but the forums themselves
were powerful and had some nifty features. Then Delphi decided to
change their charging policy, with the result that those users who
didn't want to pay would have to use a rather crippled system.

At that point, we wondered if there were any credible alternatives
to Delphi. After a lot of searching, we discovered that whilst some
other forum software offers similar features, none offered quite what
we were after. Particularly, we wanted forum software that was
guaranteed to remain free - i.e. released under some type of 
open-source licence.

Various members of the forum had the required skills to develop our
own solution (for some, software development and web design is their
day job). So we did, and released it in a way that allows everyone
to use it if they so desire. Beehive is the result.

### 1.4 Can I use Beehive on my own web site?

Of course you can (provided your server has PHP and MySQL installed
see readme.txt for more details). Beehive is released under the GNU 
General Public License (a copy of which is included with this 
distribution). That means that you may freely use, modify, and even
distribute it (we encourage you to do this). However, the conditions
of the license require that any work derived from Beehive must be
identified as such, and also be released under the GPL - i.e., you
cannot sell Beehive commercially. For more information, read the 
text of the GPL in the file called COPYING.

## 2. Installing Beehive and getting it to work

### 2.1 Where to find installation instructions

Installing Beehive is covered in readme.txt. It's a fairly simple
process, though it could be made simpler, and doubtless will be in
later releases.

## 3. Technical questions

### 3.1 How scalable is Beehive?

We've found that Beehive can easily handle our forum 
(http://www.tehforum.co.uk/), which is pretty high-traffic. The 
database layout is designed with efficiency in mind, and we leave it
up to MySQL to do all the big data-crunching. In short, don't worry
(provided you have enough disk space to store the database, you'll be
fine).

### 3.2 Why did you write it in PHP?

Because PHP is the best language ever, ever. It's fast, very powerful,
and free. You can run Beehive without paying any software costs (use
Linux, Apache, MySQL, and PHP). The other, more practical reason is
that we already knew it.

## 4. Other questions

### 4.1 Why the fixation with bees?

We're not really sure. The name Beehive was suggested since we wanted
something that reflected the forum as a community (which, after all,
is what a beehive is). If you're not that keen on bees, you can change
the default style to one of the others, and the bees will be gone.
The forum owner will still be called the "queen", but tough. No-one
has to know that, anyway.

### 4.2 I hate frames. Why did you use them?

The community which is now Teh Forum has used many different types of
online discussion media in its time. And this is our favourite. Sorry.

## 5. Improving Beehive

### 5.1 Beehive doesn't do x. Can you make it do that?

We welcome feedback, bug reports, and requests for extra features etc.
The best place is to ask is probably Teh Forum at 
http://www.tehforum.co.uk/ But bear in mind that we do this in our
spare time.

Of course, since Beehive is open source, you could always implement
whatever feature you want yourself. We'd love you to submit patches.

## 6. Troubleshooting

### 6.1 Database connectivity problems or permission denied errors

If you are experiencing connectivity problems or permission denied
errors, check that you have edited the config.inc.php so that the
database details match those provided by your hosting provider. Be
sure to double check the username and password. If they are incorrect
your Beehive Forum will fail to function.

### 6.2 Unknown or missing table errors

In the case of unknown or missing table errors, be sure that you have
correctly and successfully imported the schema.sql file in the docs
folder of the Beehive Forum Distribution. If you experience errors
during the import, check that your version of MySQL is recent enough
(see readme.txt for requirements)

### 6.3 Blank page errors

Blank pages can be caused by enabling the gzip compression support
in your Beehive Forum's config.inc.php. Problems arise when the server
already has gzip compression for PHP scripts enabled or a 3rd party
compression library such as mod_gzip is installed. Before reporting
this as a bug, try disabling the gzip compression in config.inc.php
of your Beehive Forum by changing the $gzip_compress_output variable
to False.

### 6.4 Error: Strict Standards: var: Deprecated on PHP/5.x

With PHP/5.0 the var modifier for variables within classes has been
deprecated, hence the error message. Under normal circumstances this
wouldn't be a problem as the error reporting level is by default set
the same as PHP/4.x. However if the level is increased to include
E_STRICT, a new reporting level which is designed to notify on less
than recommended coding practices, the above error will occur when
using your BeehiveForum. At the moment the only work around for this
is to disable / step down the error reporting to E_ALL or below.

### 6.5 Email Notifications on Windows

Please see readme.txt section 1.2.12 for information on setting up 
PHP to send email on Windows platforms.