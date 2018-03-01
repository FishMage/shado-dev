The page structure of Index.php:

1. first include the init.php file:

    1. Start a SESSION

    2. Using set_session_vars to put massive amount of parameters into SESSION:

      This includes the standard information on default_params.txt file.

      This also creates a temporary file, with sys_get_temp_dir(). The file is located in \tmp
      and the file is stored in $dir

    3. Connect to MySQL server and return a connection.

2. Require the header.php

    1. echo dynamic page title (in this case, SHOW)

    2. Just the header including the navbar.

3. The body of the HTML.

    1. Introduction

    2. Background and body of the HTML:

      Table that includes all the task type and description.

4. Include Footer.

    The footer has been commented out for some reason.

NAVBAR:

    1. The navbar directs to: index.php

    2. basic_settings.php

    3. contact_us.php

    4. version_history.php
