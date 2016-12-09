# IBMWatsonNaturalLanguageClassifier Package
Interpret natural language with custom classifiers.
* Domain: ibm.com
* Credentials: username, password

## How to get credentials: 
0. Register to [IBM Bluemix Console](https://console.ng.bluemix.net/registration/) 
1. After log in choose Natural Language Classifier from [services](https://console.ng.bluemix.net/catalog/?category=watson)
2. Connect Natural Language Classifier to your application at the left side, choose pricing plan and click on 'Create' button at the bottom of the page.
3. Click on 'Service Credentials' tab to see your username and password.

## IBMWatsonNLC.createClassifier
Sends data to create and train a classifier and returns information about the new classifier.

| Field       | Type       | Description
|-------------|------------|----------
| username    | credentials| Required: username obtained from IBM Bluemix.
| password    | credentials| Required: password obtained from IBM Bluemix.
| trainingData| File       | Required: Training data In the CSV format. Each text value must have at least one class. The data can include up to 15,000 records.
| language    | String     | Required: The language of the data. Specify the language with the 2-letter primary language code as assigned in ISO standard 639. Supported languages are English (en), Arabic (ar), French (fr), German, (de), Italian (it), Japanese (ja), Portuguese (pt), and Spanish (es).
| name        | String     | Optional: The name of the data to identify the classifier.

#### trainingData structure
Text before comma is a test to classify, text after comma is class that apply to the text. Each record has two or more columns.
```
How hot is it today?,temperature
Is it hot outside?,temperature
Is it windy?,conditions
```

## IBMWatsonNLC.listClassifiers
Retrieves the list of classifiers for the service instance. Returns an empty array if no classifiers are available.

| Field   | Type       | Description
|---------|------------|----------
| username| credentials| Required: username obtained from IBM Bluemix.
| password| credentials| Required: password obtained from IBM Bluemix.


## IBMWatsonNLC.getClassifierInformation
Returns status and other information about a classifier.

| Field       | Type       | Description
|-------------|------------|----------
| username    | credentials| Required: username obtained from IBM Bluemix.
| password    | credentials| Required: password obtained from IBM Bluemix.
| classifierId| String     | Required: Classifier ID to query.


## IBMWatsonNLC.classify
Returns label information for the input.

| Field       | Type       | Description
|-------------|------------|----------
| username    | credentials| Required: username obtained from IBM Bluemix.
| password    | credentials| Required: password obtained from IBM Bluemix.
| classifierId| String     | Required: Classifier ID to query.
| text        | String     | Required: Phrase to classify.


## IBMWatsonNLC.deleteClassifier
Deletes a classifier.

| Field       | Type       | Description
|-------------|------------|----------
| username    | credentials| Required: username obtained from IBM Bluemix.
| password    | credentials| Required: password obtained from IBM Bluemix.
| classifierId| String     | Required: Classifier ID to delete.

