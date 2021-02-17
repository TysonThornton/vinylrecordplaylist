# Creating USER table
CREATE TABLE public.user
(
	userID SERIAL NOT NULL PRIMARY KEY,
	username VARCHAR(100) NOT NULL UNIQUE,
	userpassword VARCHAR(100) NOT NULL,
	useremail VARCHAR(100) NOT NULL UNIQUE
);


# Creating the VINYL table
CREATE TABLE public.vinyl
(
	vinylID SERIAL NOT NULL PRIMARY KEY,
	vinylband VARCHAR(100) NOT NULL,
	vinylalbumn VARCHAR(100) NOT NULL,
	vinylyear INT NOT NULL,
	vinylcondition VARCHAR(100),
	vinylgenre VARCHAR(100),
	userID INT NOT NULL REFERENCES public.user(userID)
);


# Creating the IMAGE table
CREATE TABLE public.image
(
	imageID SERIAL NOT NULL PRIMARY KEY,
	imageName VARCHAR(100) NOT NULL,
	imagePath VARCHAR(100) NOT NULL,
	vinylID INT NOT NULL REFERENCES public.vinyl(vinylID),
	wishlistID INT NOT NULL REFERENCES public.wishlist(wishlistID)
);


# Add foreign key constraint to VINYL table for Image
ALTER TABLE public.vinyl ADD COLUMN
imageID INT NOT NULL REFERENCES public.image(imageID);




# Creating WISHLIST table
CREATE TABLE public.wishlist
(
	wishlistID SERIAL NOT NULL PRIMARY KEY,
	wlVinylBand VARCHAR(100) NOT NULL,
	wlVinylAlbum VARCHAR(100) NOT NULL,
	wlVinylprice FLOAT NOT NULL,
	wlVinylnotes TEXT,
	userID INT NOT NULL REFERENCES public.user(userid)
);

ALTER TABLE public.wishlist ADD COLUMN
imageID INT NOT NULL REFERENCES public.image(imageID);