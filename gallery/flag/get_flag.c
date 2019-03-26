#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <fcntl.h>
#include <sys/time.h>

int main() {
    char buf[1000];
    FILE* fdflag = fopen("/flag", "r");
    fread(buf, 1, sizeof(buf), fdflag);
    printf("%s\n", buf);
    fflush(stdout);
    return 0;
}
