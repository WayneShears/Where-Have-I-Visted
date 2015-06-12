# Where-Have-I-Visted
A tool where a user can enter a place they have visited and submit the data to a MySQL database using PHP. The map is generated using Google Maps v3 API.

#Using with multiple communites

This can be easily used in a community with multiple users. As this is how I am using it. I have just made a few changes to make it a more stand alone version.

To make this work in a community I would recommend doing the following:
* Add a coulmn to your SQL table called user_id or similar to store the users id number so we can tie their markers back to their account
* Change the INSERT statement in the code (Page X, Line X) to add a $userid or similar variable where you are storing the users ID for your community.
* When displaying your users indvidual map ensure you add the user ID to the SELECT statement so it shows the correct user.


# Contact
If you have a question about this please contact me with the subject "Github: Google Maps API" I will see if I can help you out.
