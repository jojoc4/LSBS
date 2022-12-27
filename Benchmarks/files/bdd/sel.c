#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sqlite3.h> 
#include <unistd.h>
#include <fcntl.h>
#include <time.h>
#include<sys/time.h>


double ftime()
{
	struct timeval tv;
	gettimeofday(&tv, 0);
	return tv.tv_usec * 1e-6 + tv.tv_sec;
}


static int callback_header = 0;

static int callback_print(void *data, int argc, char **argv, char **azColName)
{
//	fprintf(stderr, "%s: ", (const char*)data);

	if (!callback_header) {
		for (int i = 0; i<argc; i++) {
			//if (i)
				//printf(";");
			//printf("%s", azColName[i]);
		}
		//printf("\n");
		callback_header = 1;
	}
	for (int i = 0; i<argc; i++) {
		//if (i)
			//printf(";");
		//printf("%s", argv[i] ? argv[i] : "NULL");
	}
	//printf("\n");
	return 0;
}

static int callback_null(void *data, int argc, char **argv, char **azColName)
{
	return 0;
}

char *nums[10000][10];
int numsize=0;

static int callback_save_nums(void *data, int argc, char **argv, char **azColName)
{
	char yolo[10];
	strcpy(yolo, argv[0]);
	*nums[numsize] = yolo;
	numsize++;
	return 0;
}


int main(int argc, char* argv[])
{
	char *dbfile = "tel.db";
	char *sqlcommand = "SELECT DISTINCT orig FROM calls;";
	int (*callbackfun)(void *, int, char **, char **) = callback_save_nums;

	int fd = open(dbfile, O_RDONLY);
	if (fd < 0) {
		fprintf(stderr, "Can't open database file: %s\n", dbfile);
		return 1;
	}
	close(fd);

	sqlite3 *db;
	int rc = sqlite3_open(dbfile, &db);
	if (rc) {
		fprintf(stderr, "Can't open database contents: %s\n", sqlite3_errmsg(db));
		return 1;
	}

	/* retrieve numbers */
	char *zErrMsg = 0, *data = 0;

	rc = sqlite3_exec(db, sqlcommand, callbackfun, (void*)data, &zErrMsg);


	callbackfun = callback_null;

	for (int i = 0; i<numsize; i++) {
		char *zErrMsg = 0, *data = 0;
		char source[] = "'";
		char num[] = "0000000000";
		//printf("%s", *nums[i]);
		strcpy(num, *nums[i]);
		char destination[] = "SELECT SUM(cost) FROM calls WHERE orig='";
		strcat(destination, num);
		strcat(destination, source);
		// printf("%s\n", destination);
		sqlcommand = destination;
		double stime = ftime();
		rc = sqlite3_exec(db, sqlcommand, callbackfun, (void*)data, &zErrMsg);
		double etime = ftime();
		//fprintf(stdout, "%i;%f\n", i, (etime - stime));
	}

	// if ( rc != SQLITE_OK ) {
	// 	fprintf(stderr, "SQL error: %s\n", zErrMsg);
	// 	sqlite3_free(zErrMsg);
	// } else {
	// 	fprintf(stdout, "Operation done successfully in %f seconds\n", (etime - stime));
	// }

	sqlite3_close(db);

	return rc == SQLITE_OK ? 0 : 1;
}
//gcc sel.c -o sel1 -lsqlite3 && ./sel1 > results.csv