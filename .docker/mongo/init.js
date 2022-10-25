db = db.getSiblingDB(_getEnv("MONGO_INITDB_DATABASE"));
db.log.insertOne({
    "user" : _getEnv("MONGO_INITDB_ROOT_USERNAME"),
    "message": "Database "+ _getEnv("MONGO_INITDB_DATABASE") + " dibuat"
});