### Objective

Your assignment is to implement a URL shortening service using raw PHP without any PHP framework.

### Brief

ShortLink is a URL shortening service where you enter a URL such as https://support.payplux.com/getting-started.html and it returns a short URL such as http://short.est/Ze9AK.
Create a class to do the hashing.

### Tasks

-   Implement assignment using:
    -   Stack: **Php/Mysql**
    -   Framework: **none** 
    -   Two endpoints are required
        -   /encode - Encodes a URL to a shortened URL
        -   /decode - Decodes a shortened URL to its original URL.
    -   Both endpoints should return JSON
-   There is no restriction on how your encode/decode algorithm should work. You just need to make sure that a URL can be encoded to a short URL and the short URL can be decoded to the original URL.
-   Provide basic instructions on how to install and run your assignment in a separate markdown file named DOCUMENTATION.md

Optional
-   Provide Unit tests for Hashing class only

### Evaluation Criteria
-   Object Oriented Programming
-   API implemented featuring a /encode and /decode endpoint
-   Creating your custom Class to access mysql database preferred over using third-party library.
-   Algorithm for hashing would not be judged.
-   Validation of http request.
-   directory structure

### Submission

Please organize, test and document your code as if it were going into production - then push your code to the remote repo given by the HR.

All the best and happy coding!

The PayPlux Team