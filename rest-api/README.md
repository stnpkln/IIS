# IIS - REST API

IIS project - Social Network

## Dependencies

node v18
npm v9

## ENV

create the following .nodemon.json file in /rest-api

```
{
	"env": {
		"PORT": 3000,
		"DB_USER": "root",
		"DB_PASSWORD": "mameradiiis",
		"DB_NAME": "iisDb",
		"DB_PORT": 5432,
		"DB_HOST": "postgres",
		"ENVIRONMENT": "DEV"
	}
}

```

## installing packages

in /rest-api run `npm i`

## Running the API

to run REST API, cd to /rest-api and run `npm run dev`
the API will be running on address localhost:3000

```

```
