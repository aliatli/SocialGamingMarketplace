import java.sql.*;

public class Database{
	public static void main(String[] args) {
		Statement stmt = null;
		Connection conn = null;
		try {
			String server = "jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr/cagatay_kupeli";
			String name = "cagatay.kupeli";
			String pass = "rxtnb2bwh";
			conn = DriverManager.getConnection(server, name, pass);
			
			stmt = conn.createStatement();
			//drop existing tables
			stmt.executeUpdate("DROP TABLE IF EXISTS FriendList;");
			stmt.executeUpdate("DROP TABLE IF EXISTS Buy;");
			stmt.executeUpdate("DROP TABLE IF EXISTS BlockList;");
			stmt.executeUpdate("DROP TABLE IF EXISTS Write_Review;");
			stmt.executeUpdate("DROP TABLE IF EXISTS WishList;");
			stmt.executeUpdate("DROP TABLE IF EXISTS Discount_Card;");
			stmt.executeUpdate("DROP TABLE IF EXISTS Belong;");
			stmt.executeUpdate("DROP TABLE IF EXISTS Genre;");
			stmt.executeUpdate("DROP TABLE IF EXISTS Member;");
			stmt.executeUpdate("DROP TABLE IF EXISTS Comment;");
			stmt.executeUpdate("DROP TABLE IF EXISTS `Group`;");
			stmt.executeUpdate("DROP TABLE IF EXISTS In_Game_Item;");
			stmt.executeUpdate("DROP TABLE IF EXISTS Item;");
			stmt.executeUpdate("DROP TABLE IF EXISTS Inventory;");
			stmt.executeUpdate("DROP TABLE IF EXISTS User;");
			stmt.executeUpdate("DROP TABLE IF EXISTS Game;");
			
			//create new tables
			String sql;
			sql = "CREATE TABLE IF NOT EXISTS User"
					+ "(UserID INT NOT NULL AUTO_INCREMENT,"
					+ "FirstName VARCHAR(16) NOT NULL,"
					+ "LastName VARCHAR(16) NOT NULL,"
					+ "UserName VARCHAR(16) NOT NULL UNIQUE,"
					+ "Email VARCHAR(32) NOT NULL UNIQUE,"
					+ "Password VARCHAR(256) NOT NULL,"
					+ "DateOfBirth DATE NOT NULL,"
					+ "Balance NUMERIC(8,2) DEFAULT 0 NOT NULL,"
					+ "CardNo BIGINT,"
					+ "Cvv SMALLINT,"
					+ "BillingAdress VARCHAR(128),"
					+ "PRIMARY KEY (UserID)) ENGINE=innodb;";
			stmt.executeUpdate(sql);
			System.out.println("Created table User in the database");
			
			sql = "CREATE TABLE IF NOT EXISTS Game"
					+ "(GameID INT NOT NULL AUTO_INCREMENT,"
					+ "Name VARCHAR(16) NOT NULL UNIQUE,"
					+ "AgeRestriction TINYINT NOT NULL,"
					+ "Price NUMERIC(8,2) NOT NULL,"
					+ "Rating TINYINT,"
					+ "NumberOfPlayers TINYINT NOT NULL,"
					+ "SystemRequirements VARCHAR(256) NOT NULL,"
					+ "Info VARCHAR(64) NOT NULL,"
					+ "PRIMARY KEY (GameID)) ENGINE=innodb;";
			stmt.executeUpdate(sql);
			System.out.println("Created table Game in the database");
			
			sql = "INSERT INTO Game (Name, AgeRestriction, Price, Rating, NumberOfPlayers, SystemRequirements, Info) VALUES ('Name 1', 12, 14.5, 4, 3, 'System requirements 1', 'Info 1');";
			stmt.executeUpdate(sql);
			
			sql = "INSERT INTO Game (Name, AgeRestriction, Price, Rating, NumberOfPlayers, SystemRequirements, Info) VALUES ('Name 2', 18, 27.5, 3, 2, 'System requirements 2', 'Info 2');";
			stmt.executeUpdate(sql);
			
			sql = "INSERT INTO Game (Name, AgeRestriction, Price, Rating, NumberOfPlayers, SystemRequirements, Info) VALUES ('Name 3', 15, 11.5, 4, 1, 'System requirements 3', 'Info 2');";
			stmt.executeUpdate(sql);
			
			sql = "INSERT INTO Game (Name, AgeRestriction, Price, Rating, NumberOfPlayers, SystemRequirements, Info) VALUES ('Name 4', 11, 11.5, 2, 6, 'System requirements 4', 'Info 4');";
			stmt.executeUpdate(sql);
			
			sql = "INSERT INTO Game (Name, AgeRestriction, Price, Rating, NumberOfPlayers, SystemRequirements, Info) VALUES ('Name 5', 18, 27, 2, 1, 'System requirements 5', 'Info 5');";
			stmt.executeUpdate(sql);
			
			sql = "INSERT INTO Game (Name, AgeRestriction, Price, Rating, NumberOfPlayers, SystemRequirements, Info) VALUES ('Name 6', 28, 1, 4, 3, 'System requirements 6', 'Info 6');";
			stmt.executeUpdate(sql);
			
			sql = "CREATE TABLE IF NOT EXISTS Buy"
					+ "(UserUserID INT NOT NULL,"
					+ "GameGameID INT NOT NULL,"
					+ "PRIMARY KEY(UserUserID, GameGameID),"
					+ "CONSTRAINT UserUserID_b FOREIGN KEY(UserUserID) REFERENCES User(UserID) ON DELETE CASCADE ON UPDATE CASCADE,"
					+ "CONSTRAINT GameGameID_b FOREIGN KEY(GameGameID) REFERENCES Game(GameID) ON DELETE CASCADE ON UPDATE CASCADE)"
					+ "ENGINE=innodb;";
			stmt.executeUpdate(sql);
			System.out.println("Created table Buy in the database");
			
			sql = "CREATE TABLE IF NOT EXISTS FriendList"
					+ "(UserUserID INT NOT NULL,"
					+ "UserUserID2 INT NOT NULL,"
					+ "PRIMARY KEY(UserUserID, UserUserID2),"
					+ "CONSTRAINT UserUserID FOREIGN KEY(UserUserID) REFERENCES User(UserID),"
					+ "CONSTRAINT UserUserID2 FOREIGN KEY(UserUserID2) REFERENCES User(UserID)) ENGINE=innodb;";
			stmt.executeUpdate(sql);
			System.out.println("Created table FriendList in the database");
			
			sql = "CREATE TABLE IF NOT EXISTS BlockList"
					+ "(UserUserID INT NOT NULL,"
					+ "UserUserID2 INT NOT NULL,"
					+ "PRIMARY KEY(UserUserID, UserUserID2),"
					+ "CONSTRAINT UserUserID_bl FOREIGN KEY(UserUserID) REFERENCES User(UserID),"
					+ "CONSTRAINT UserUserID2_bl FOREIGN KEY(UserUserID2) REFERENCES User(UserID)) ENGINE=innodb;";
			stmt.executeUpdate(sql);
			System.out.println("Created table BlockList in the database");
			
			sql = "CREATE TABLE IF NOT EXISTS Write_Review"
					+ "(UserUserID INT NOT NULL,"
					+ "GameGameID INT NOT NULL,"
					+ "Comment VARCHAR(128) NOT NULL,"
					+ "Rating TINYINT NOT NULL,"
					+ "Date DATE NOT NULL,"
					+ "PRIMARY KEY(UserUserID, GameGameID),"
					+ "CONSTRAINT UserUserID_wr FOREIGN KEY(UserUserID) REFERENCES User(UserID) ON DELETE CASCADE ON UPDATE CASCADE,"
					+ "CONSTRAINT GameGameID_wr FOREIGN KEY(GameGameID) REFERENCES Game(GameID) ON DELETE CASCADE ON UPDATE CASCADE)"
					+ "ENGINE=innodb;";
			stmt.executeUpdate(sql);
			System.out.println("Created table Write_Review in the database");
			
			sql = "CREATE TABLE IF NOT EXISTS WishList"
					+ "(UserUserID INT NOT NULL,"
					+ "GameGameID INT NOT NULL,"
					+ "PRIMARY KEY(UserUserID, GameGameID),"
					+ "CONSTRAINT UserUserID_wl FOREIGN KEY(UserUserID) REFERENCES User(UserID) ON DELETE CASCADE ON UPDATE CASCADE,"
					+ "CONSTRAINT GameGameID_wl FOREIGN KEY(GameGameID) REFERENCES Game(GameID) ON DELETE CASCADE ON UPDATE CASCADE)"
					+ "ENGINE=innodb;";
			stmt.executeUpdate(sql);
			System.out.println("Created table WishList in the database");
			
			sql = "CREATE TABLE IF NOT EXISTS Item"
					+ "(ItemID INT NOT NULL,"
					+ "GameGameID INT NOT NULL,"
					+ "Name VARCHAR(16) NOT NULL,"
					+ "Info VARCHAR(16) NOT NULL,"
					+ "PRIMARY KEY(ItemID),"
					+ "CONSTRAINT GameGameID_i FOREIGN KEY(GameGameID) REFERENCES Game(GameID) ON DELETE CASCADE ON UPDATE CASCADE)"
					+ "ENGINE=innodb;";
			stmt.executeUpdate(sql);
			System.out.println("Created table Item in the database");
			
			sql = "CREATE TABLE IF NOT EXISTS Inventory"
					+ "(UserUserID INT NOT NULL,"
					+ "ItemItemID INT NOT NULL,"
					+ "PRIMARY KEY(UserUserID, ItemItemID),"
					+ "CONSTRAINT UserUserID_inv FOREIGN KEY(UserUserID) REFERENCES User(UserID) ON DELETE CASCADE ON UPDATE CASCADE,"
					+ "CONSTRAINT ItemItemID_inv FOREIGN KEY(ItemItemID) REFERENCES Game(GameID) ON DELETE CASCADE ON UPDATE CASCADE)"
					+ "ENGINE=innodb;";
			stmt.executeUpdate(sql);
			System.out.println("Created table Inventory in the database");
			
			sql = "CREATE TABLE IF NOT EXISTS Discount_Card"
					+ "(ItemID INT NOT NULL,"
					+ "DiscountRate NUMERIC(2,1) NOT NULL,"
					+ "PRIMARY KEY(ItemID),"
					+ "CONSTRAINT ItemID_dc FOREIGN KEY(ItemID) REFERENCES Item(ItemID) ON DELETE CASCADE ON UPDATE CASCADE)"
					+ "ENGINE=innodb;";
			stmt.executeUpdate(sql);
			System.out.println("Created table Discount_Card in the database");
			
			sql = "CREATE TABLE IF NOT EXISTS In_Game_Item"
					+ "(ItemID INT NOT NULL,"
					+ "Price NUMERIC(8,2) NOT NULL,"
					+ "PRIMARY KEY(ItemID),"
					+ "CONSTRAINT ItemID_igi FOREIGN KEY(ItemID) REFERENCES Item(ItemID) ON DELETE CASCADE ON UPDATE CASCADE)"
					+ "ENGINE=innodb;";
			stmt.executeUpdate(sql);
			System.out.println("Created table In_Game_Item in the database");
			
			sql = "CREATE TABLE IF NOT EXISTS Genre"
					+ "(GenreID INT NOT NULL AUTO_INCREMENT,"
					+ "Type VARCHAR(16) NOT NULL,"
					+ "PRIMARY KEY(GenreID)) ENGINE=innodb;";
			stmt.executeUpdate(sql);
			System.out.println("Created table Genre in the database");
			
			sql = "INSERT INTO Genre (Type) VALUES ('action');";
			stmt.executeUpdate(sql);

			sql = "INSERT INTO Genre (Type) VALUES ('sport');";
			stmt.executeUpdate(sql);
			
			sql = "INSERT INTO Genre (Type) VALUES ('strategy');";
			stmt.executeUpdate(sql);
			
			sql = "INSERT INTO Genre (Type) VALUES ('fps');";
			stmt.executeUpdate(sql);
			
			sql = "CREATE TABLE IF NOT EXISTS Belong"
					+ "(GameGameID INT NOT NULL,"
					+ "GenreGenreID INT NOT NULL,"
					+ "PRIMARY KEY(GameGameID, GenreGenreID),"
					+ "CONSTRAINT GameGameID_be FOREIGN KEY(GameGameID) REFERENCES Game(GameID) ON DELETE CASCADE ON UPDATE CASCADE,"
					+ "CONSTRAINT GenreGenreID_be FOREIGN KEY(GenreGenreID) REFERENCES Genre(GenreID) ON DELETE CASCADE ON UPDATE CASCADE)"
					+ "ENGINE=innodb;";
			stmt.executeUpdate(sql);
			System.out.println("Created table Belong in the database");
			
			sql = "INSERT INTO Belong (GameGameID, GenreGenreID) VALUES (1, 1);";
			stmt.executeUpdate(sql);
			
			sql = "INSERT INTO Belong (GameGameID, GenreGenreID) VALUES (1, 2);";
			stmt.executeUpdate(sql);
			
			sql = "INSERT INTO Belong (GameGameID, GenreGenreID) VALUES (2, 2);";
			stmt.executeUpdate(sql);
			
			sql = "INSERT INTO Belong (GameGameID, GenreGenreID) VALUES (1, 3);";
			stmt.executeUpdate(sql);
			
			sql = "INSERT INTO Belong (GameGameID, GenreGenreID) VALUES (1, 4);";
			stmt.executeUpdate(sql);
			
			sql = "INSERT INTO Belong (GameGameID, GenreGenreID) VALUES (3, 1);";
			stmt.executeUpdate(sql);
			
			sql = "INSERT INTO Belong (GameGameID, GenreGenreID) VALUES (3, 2);";
			stmt.executeUpdate(sql);
			
			sql = "INSERT INTO Belong (GameGameID, GenreGenreID) VALUES (4, 4);";
			stmt.executeUpdate(sql);
			
			sql = "INSERT INTO Belong (GameGameID, GenreGenreID) VALUES (5, 3);";
			stmt.executeUpdate(sql);
			
			sql = "INSERT INTO Belong (GameGameID, GenreGenreID) VALUES (6, 1);";
			stmt.executeUpdate(sql);
			
			sql = "CREATE TABLE IF NOT EXISTS `Group`"
					+ "(GroupID INT NOT NULL,"
					+ "Name VARCHAR(16) NOT NULL,"
					+ "CreationDate DATE NOT NULL,"
					+ "PRIMARY KEY(GroupID)) ENGINE=innodb;";
			stmt.executeUpdate(sql);
			System.out.println("Created table Group in the database");
			
			sql = "CREATE TABLE IF NOT EXISTS Member"
					+ "(UserUserID INT NOT NULL,"
					+ "GroupGroupID INT NOT NULL,"
					+ "Date DATE NOT NULL,"
					+ "PRIMARY KEY(UserUserID, GroupGroupID),"
					+ "CONSTRAINT UserUserID_mem FOREIGN KEY(UserUserID) REFERENCES User(UserID) ON DELETE CASCADE ON UPDATE CASCADE,"
					+ "CONSTRAINT GroupGroupID_mem FOREIGN KEY(GroupGroupID) REFERENCES `Group`(GroupID) ON DELETE CASCADE ON UPDATE CASCADE)"
					+ "ENGINE=innodb;";
			stmt.executeUpdate(sql);
			System.out.println("Created table Member in the database");
			
			sql = "CREATE TABLE IF NOT EXISTS Comment"
					+ "(UserUserID INT NOT NULL,"
					+ "GroupGroupID INT NOT NULL,"
					+ "Content VARCHAR(256) NOT NULL,"
					+ "Date DATE NOT NULL,"
					+ "PRIMARY KEY(UserUserID, GroupGroupID),"
					+ "CONSTRAINT UserUserID_com FOREIGN KEY(UserUserID) REFERENCES User(UserID) ON DELETE CASCADE ON UPDATE CASCADE,"
					+ "CONSTRAINT GroupGroupID_com FOREIGN KEY(GroupGroupID) REFERENCES `Group`(GroupID) ON DELETE CASCADE ON UPDATE CASCADE)"
					+ "ENGINE=innodb;";
			stmt.executeUpdate(sql);
			System.out.println("Created table Comment in the database");

		}catch (SQLException sqle) {
			sqle.printStackTrace();
		} catch (Exception e) {
			e.printStackTrace();
		}finally {
			try {
				if (stmt != null) {
					conn.close();
				}
			} catch (SQLException sqle) {
			}
			try {
				if (conn != null) {
					conn.close();
				}
			} catch (SQLException sqle) {
				sqle.printStackTrace();
			}
		}
		System.out.println("All done!");
	}
}
