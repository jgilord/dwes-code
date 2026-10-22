CREATE USER 'userPistas'@'%' IDENTIFIED BY 'userPistas';
GRANT ALL PRIVILEGES ON `reserva-pistas`.* TO 'userPistas'@'%';
FLUSH PRIVILEGES;
