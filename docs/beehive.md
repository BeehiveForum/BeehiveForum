# PROJECT BEEHIVE

1. AIM

    To create a replacement forum similar in functionality to a Delphi
    forum in Advanced mode. Simple, eh?

2. HOW?

    It's written in PHP, with a MySQL backend, but the way it's written
    should make it possible to change the database without too much of a
    problem.

3. LICENCE

    It's released under the GNU General Public License (GPL), which is
    an open-source license that means anyone is free to use, modify,
    and redistribute it, with a few restrictions. That means that the
    following text should be included as a comment at the top of every
    source file:

        =====================================================================  
        Copyright [your name] 2002

        This file is part of Beehive.

        Beehive is free software; you can redistribute it and/or modify
        it under the terms of the GNU General Public License as published by
        the Free Software Foundation; either version 2 of the License, or
        (at your option) any later version.

        Beehive is distributed in the hope that it will be useful,
        but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
        GNU General Public License for more details.

        You should have received a copy of the GNU General Public License  
        along with Beehive; if not, write to the Free Software  
        Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  
        USA  
        =====================================================================

    (obviously, replace [your name] with your name. If anyone else works
    on the file, add their name too).

4. CODING GUIDELINES

    - Markup

        We're going for XHTML compliance. Seeing as we're going to be using
        frames, it's not going to be strict, but there we go. Formatting
        needs to be done with CSS, not just to make it valid XHTML, but
        also because then it's easily customisable. We're aiming to have a
        single CSS file which almost completely determines the look of the
        forum. So no inline styles (unless you have a very good reason),
        and definitly no nasty <font> tags, OK?

    - PHP

        Lots of comments, please. Bear in mind that lots of people might
        have to work on the same file, so we need to know what your code
        does.

        There's no need to comment every line, but sticking a comment in
        before every block of code as a summary of what it does helps
        immensely when someone else is trying to figure out what you've
        been up to with your PHP madskillz.

        Conversely, if you think a particular line of code might not be
        obvious in describing what it does, comment it. People will thank
        you for it when it saves them from having to parse regular
        expressions in their heads.

        Coding style - not phenomenally important, but it would be nice
        if we kept to a consistent style throughout. Most people on the
        forum who have shown me code in the past seem to use "1 true
        brace" style, so we might as well. Opening curly braces go on
        the same line as their control statement, and the closing one
        isn't indented, like this:

            if ($wibble) {  
                something;  
            }

        The exception is functions, which look like this (opening brace
        on the next line):

            function wibble()
            {
                something;
            }

4. SQL

    Please fully qualify INSERT statements, i.e. instead of just:

    `INSERT INTO TABLE VALUES (3, 'miffle', 42);`

    do:

    `INSERT INTO TABLE (FIELD1, FIELD2, FIELD3) VALUES (3, 'miffle', 42);`

    If you specify the fields that you're INSERTing into, than that
    means that we don't break your code if we have to add another
    field to a table, which is a good thing.

    Also, bear in mind table names are case-sensitive, so need to be
    in upper-case.

5. STRUCTURE

        |  
        |-- docs       this is where documentation and anything that  
        |              isn't actually needed to run the forum goes.  
        |  
        |-- forum      this is the forum proper  
        |     |  
        |     |-- images        Images, suprisingly  
        |     |-- include       Included function files  
        |     |-- styles        Stylesheets