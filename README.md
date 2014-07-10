WashtenawVoiceSOQ
=================

##About the project

This project is the result of The Washtenaw Voice’s effort to make the Student Opinion Questionnaires open and available for students.  

Articles related to the subject can be found here:

http://www.washtenawvoice.com/2014/03/soqs-college-to-release-soqs/
http://www.washtenawvoice.com/2014/01/soq-the-customers-right/
http://www.washtenawvoice.com/2014/04/pride-runs-deep-over-voices-soq-fight/
http://www.washtenawvoice.com/2014/02/letter-to-the-editor-soqs-are-not-the-students-right/
http://www.washtenawvoice.com/2014/02/letter-to-the-editor-a-modest-proposal/

This is an open-source project coded in PHP with a MySQL database (i.e. the LAMP stack).

Collaboration and participation from any student/faculty/staff is welcomed. The Voice’s goal is to be transparent in the process of presenting the data to the community and we believe we can make this a tool that benefits everyone.

##About the SOQ’s

There are 3 kinds of SOQ’s with different question sets.
Skill Building
Distance Learning
On-site/traditional class

The college further divides the SOQ’s between part-time and full-time staff, however the question sets are not different. Therefore for the purposes of this project we will treat part-time and full-time staff as the same since that does not seem to have any relevancy for the student experience. We can change this by adding an additional field, however, instructors do change from being part-time versus full-time. Any feedback on this is welcome.

The SOQ summary data display’s the total numbers for each answer column. Students rate their instructors on a scale of 1-5. The summary data then provides a mean total of that data along with a mean total for the college followed by a standard deviation.

We are only storing the cummulative mean given in the SOQ, not the detailed count from columns 1-5.  The mean is a float number between 1-5. We are not storing the standard deviation in the database since that can be calculated in our code.

##About the Database
The database is constructed in MySQL.  A visual model is available for further details.

##Feature Set

1.  Create a search page where users can find the information on their instructor.  Have options to drill down into the data by term and class.

2. Display the data in a bar or line graph or chart to make it visually easy to compare results and trends.

3. If possible link to the rate my professor profile if available and show the star rating in comparison to the colleges SOQ. This can be held for future development.


