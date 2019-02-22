### 网站的静态资源和gzip压缩

**查看一个网站是否使用gzip压缩**
```
curl -I -H "Accept-Encoding:gzip,deflate" "http://www.jiangliang738.cn"
```

* 结果

```
Content-Encoding:gzip
```

