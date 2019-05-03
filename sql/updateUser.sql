UPDATE users
SET users.username=:username,users.password=:password,users.firstname=:firstname,users.lastname=:lastname
WHERE userid=:userid;