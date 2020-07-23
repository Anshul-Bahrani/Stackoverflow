# Stackoverflow

## About
A website inspired from stackoverflow wherein users can ask questions and/or answer to other's questions with an voting system from both the questions and answers alike.

# User POV:
- A platform to ask questions and/or answer some questions.
- Get Notified with Mail about the answers posted on your question so you dont have to check again and again.
- Mark the best possible answer to your question to mark the question as answered.
- Upvote/Downvote a question/answer based on your opinion.
- Check how many people viewed your/someother question.
- Ask a question with trix editor inorder to truely say what you want to.
- Restricted access so that only you can edit/delete your answers/questions(if not answered).
- Get an overview about the question being unanswered/answers available/Answered without viewing the question itself.
- Paginated view so that you dont have to scroll till eternity.

# Developer POV:
## Database:
- The database included questions,answers,votes and other bridging tables
- Votes can be of either question or answer so morph relation was used in laravel.
- The filling of database at first was done using Seeder classes along with Factories of Models.
- Along with that the notifications sent to users are stored and can be retrieved so that the user can view them again.

## Question 

### Model ###

- Contains relationship methods:many(Question):one(User) with User
- Containes Helper methods:markBestAnswer and other votes method to manage the votes of that question.
- Containes accessor methods: which follow the getXXXAttribute way, so to access by an object of question we can do question->xxx to get it.

### Controller ###
- Resourceful Controller as standard as it can be...
- BackEnd Validation of the data coming to the server to get stored in the DB using Request Subclasses Like CreateQuestionRequest.
- CRUD Operations with an addition of softdeletes.

### Views ###
- Created using bootstrap includes all the features as mentioned in the User POV to get an idea.

## Answer

Same Things as menthioned in the Questions Category...with middlewares and Validations and ResourceFul Controller and stuff.

And More controllers Like VotesController, FavoritiesController(To mark an answer as favorite) with standard working.. :)

## Policies

In addidtion to this to have a better control over the access part, used Policies for Questions and Answers Controller so that no access violations are done.

## Notifications/NewReplyAdded

The mailer of Laravel, If a new reply is added, the owner of the question is notified via Mail along with the same entry done in the database to view later on.
- The server used for smtp was mailtrap.io.
