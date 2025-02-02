a, b, c = list(map(int, input().split()))
if a>=94 and a<=727 and b>=94 and b<=727 and c>=94 and c<=727:
    print(max(a,b,c))
else:
    print("Error")