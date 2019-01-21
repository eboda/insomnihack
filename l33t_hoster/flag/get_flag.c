#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <fcntl.h>
#include <sys/time.h>

void timer_handler (int signum)
{
 static int count = 0;
 printf ("timer expired %d times\n", ++count);
}

int main() {
    setbuf(stdout, NULL);
    struct itimerval timer;
    timer.it_value.tv_sec = 0;
    timer.it_value.tv_usec = 10000;
    timer.it_interval.tv_sec = 0;
    timer.it_interval.tv_usec = 0;
    setitimer (ITIMER_REAL, &timer, NULL);

    unsigned int nums[5];
    unsigned long long res = 0;
    unsigned long long solution = 0;
    FILE* fd;

    if (!(fd = fopen("/dev/urandom", "r"))) {
        printf("no random...\n");
        exit(-1);
    }

    if (fread(nums, 1, sizeof(nums), fd) != sizeof(nums)) {
        printf("no random...\n");
        exit(-1);
    }

    for (int i = 0; i < 5; i++)
        res += (unsigned long long)nums[i];

    printf("Please solve this little captcha:\n");
    fflush(stdout);
    for (int i = 0; i < 4; i++)
        printf("%u + ", nums[i]);
    printf("%u\n", nums[4]);
    fflush(stdout);

    scanf("%llu", &solution);

    if (solution == res) {
        char buf[100];
        FILE* fdflag = fopen("flag", "r");
        fread(buf, 1, sizeof(buf), fdflag);
        printf("%s\n", buf);
        fflush(stdout);
    } else {
        printf("%llu != %llu :(\n", res, solution);
        fflush(stdout);
    }
    return 0;
}
