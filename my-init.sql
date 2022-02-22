create schema absolut_fake;
create user 'uabsolut'@'localhost' identified by 'password';
grant all privileges on absolut_fake.* to 'uabsolut'@'localhost';
flush privileges;

create schema absolut_fake_sms;
create user 'uabsolutsms'@'localhost' identified by 'password';
grant all privileges on absolut_fake_sms.* to 'uabsolutsms'@'localhost';
flush privileges;
