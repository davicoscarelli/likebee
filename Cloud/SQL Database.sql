--
CREATE DATABASE  likebee


CREATE TABLE login (
  id int NOT NULL,
  username nvarchar(255) NOT NULL,
  password nvarchar(255) NOT NULL,
) 

INSERT INTO login (id, username, password) VALUES
(1, 'davicoscarelli', 'pass123'),
(2, 'icarobaacelar', 'pass123');

CREATE TABLE markers (
  id int NOT NULL,
  username nvarchar(30) NOT NULL,
  name nvarchar(60) NOT NULL,
  address nvarchar(80) NOT NULL,
  lat float NOT NULL,
  lng float NOT NULL,
  amount nvarchar(30) NOT NULL
) 

INSERT INTO markers (id, username, name, address, lat, lng, amount) VALUES
(1, 'davicoscarelli', 'Parque do Coco', 'Av. Padre Antonio Tomas', -3.744249, -38.485546, '100'),
(2, 'davicoscarelli', 'Beira Mar', 'Av. Beira Mar, 3300-3400', -3.725489, -38.491486, '50'),
(3, 'davicoscarelli', 'North Shopping', 'Rod. Pres. Juscelino Kubitschek, 2410', -3.735872, -38.566483, '10'),
(4, 'davicoscarelli', 'Messejana', 'R. Taquatiara, 89-1 ', -3.830715, -38.500690, '200')

