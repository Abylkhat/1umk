a = int(input())
flag = True
if a==1:
    flag = False
    print("NO")
while a>1:
    if a%2==1:
        print("NO")
        break
    else:
        a = int(a/2)
if a==1 and flag:
    print("YES")
