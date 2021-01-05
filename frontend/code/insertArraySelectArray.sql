CREATE TABLE "token" (
     "id"       integer PRIMARY KEY,
     "text"     text,
     "category" text[]
);

--Now you can insert multiple categories for each row into token:

INSERT INTO "token" ("id", "text", "category")
VALUES (1, 'some text', ARRAY['cate1', 'cate2']);

--You can find the rows like:

SELECT * FROM "token" WHERE 'cate1' = ANY ("category");