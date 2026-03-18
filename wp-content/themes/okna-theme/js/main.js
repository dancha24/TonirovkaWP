(function () {
  const e = document.createElement("link").relList;
  if (e && e.supports && e.supports("modulepreload")) return;
  for (const s of document.querySelectorAll('link[rel="modulepreload"]')) r(s);
  new MutationObserver((s) => {
    for (const n of s)
      if (n.type === "childList")
        for (const o of n.addedNodes)
          o.tagName === "LINK" && o.rel === "modulepreload" && r(o);
  }).observe(document, { childList: !0, subtree: !0 });
  function i(s) {
    const n = {};
    return (
      s.integrity && (n.integrity = s.integrity),
      s.referrerPolicy && (n.referrerPolicy = s.referrerPolicy),
      s.crossOrigin === "use-credentials"
        ? (n.credentials = "include")
        : s.crossOrigin === "anonymous"
          ? (n.credentials = "omit")
          : (n.credentials = "same-origin"),
      n
    );
  }
  function r(s) {
    if (s.ep) return;
    s.ep = !0;
    const n = i(s);
    fetch(s.href, n);
  }
})();
function mi(t = "max") {
  const e = "_dynamic_adapt_",
    i = "data-da",
    r = [];
  document.querySelectorAll(`[${i}]`).forEach((d) => {
    const m = d.getAttribute(i);
    if (!m) return;
    const [f, g, p] = m.split(",").map((L) => L.trim()),
      w = document.querySelector(f);
    if (!w) return;
    const S = p === "first" || p === "last" ? p : Number(p);
    r.push({
      element: d,
      parent: d.parentElement,
      to: w,
      breakpoint: g ? Number(g) : 767,
      order: S ?? "last",
      index: [...d.parentElement.children].indexOf(d),
    });
  });
  const n = [...new Set(r.map((d) => d.breakpoint))].map((d) => ({
    breakpoint: d,
    query: `(${t}-width: ${d}px)`,
    nodes: r.filter((m) => m.breakpoint === d),
  }));
  function o() {
    n.forEach(({ query: d, nodes: m }) => {
      const f = window.matchMedia(d).matches;
      m.forEach((g) => {
        f && !g.element.classList.contains(e)
          ? c(g)
          : !f && g.element.classList.contains(e) && a(g);
      });
    });
  }
  function c(d) {
    const { element: m, to: f, order: g } = d;
    (m.classList.add(e),
      g === "first"
        ? f.prepend(m)
        : g === "last" || g >= f.children.length
          ? f.append(m)
          : f.children[g].before(m));
  }
  function a(d) {
    const { element: m, parent: f, index: g } = d;
    m.classList.remove(e);
    const p = f.children;
    g >= 0 && g < p.length ? p[g].before(m) : f.append(m);
  }
  (n.forEach(({ query: d }) => {
    window.matchMedia(d).addEventListener("change", o);
  }),
    o());
}
function vt(t) {
  return (
    t !== null &&
    typeof t == "object" &&
    "constructor" in t &&
    t.constructor === Object
  );
}
function rt(t = {}, e = {}) {
  const i = ["__proto__", "constructor", "prototype"];
  Object.keys(e)
    .filter((r) => i.indexOf(r) < 0)
    .forEach((r) => {
      typeof t[r] > "u"
        ? (t[r] = e[r])
        : vt(e[r]) &&
          vt(t[r]) &&
          Object.keys(e[r]).length > 0 &&
          rt(t[r], e[r]);
    });
}
const Gt = {
  body: {},
  addEventListener() {},
  removeEventListener() {},
  activeElement: { blur() {}, nodeName: "" },
  querySelector() {
    return null;
  },
  querySelectorAll() {
    return [];
  },
  getElementById() {
    return null;
  },
  createEvent() {
    return { initEvent() {} };
  },
  createElement() {
    return {
      children: [],
      childNodes: [],
      style: {},
      setAttribute() {},
      getElementsByTagName() {
        return [];
      },
    };
  },
  createElementNS() {
    return {};
  },
  importNode() {
    return null;
  },
  location: {
    hash: "",
    host: "",
    hostname: "",
    href: "",
    origin: "",
    pathname: "",
    protocol: "",
    search: "",
  },
};
function me() {
  const t = typeof document < "u" ? document : {};
  return (rt(t, Gt), t);
}
const gi = {
  document: Gt,
  navigator: { userAgent: "" },
  location: {
    hash: "",
    host: "",
    hostname: "",
    href: "",
    origin: "",
    pathname: "",
    protocol: "",
    search: "",
  },
  history: { replaceState() {}, pushState() {}, go() {}, back() {} },
  CustomEvent: function () {
    return this;
  },
  addEventListener() {},
  removeEventListener() {},
  getComputedStyle() {
    return {
      getPropertyValue() {
        return "";
      },
    };
  },
  Image() {},
  Date() {},
  screen: {},
  setTimeout() {},
  clearTimeout() {},
  matchMedia() {
    return {};
  },
  requestAnimationFrame(t) {
    return typeof setTimeout > "u" ? (t(), null) : setTimeout(t, 0);
  },
  cancelAnimationFrame(t) {
    typeof setTimeout > "u" || clearTimeout(t);
  },
};
function Z() {
  const t = typeof window < "u" ? window : {};
  return (rt(t, gi), t);
}
function vi(t = "") {
  return t
    .trim()
    .split(" ")
    .filter((e) => !!e.trim());
}
function Si(t) {
  const e = t;
  Object.keys(e).forEach((i) => {
    try {
      e[i] = null;
    } catch {}
    try {
      delete e[i];
    } catch {}
  });
}
function Bt(t, e = 0) {
  return setTimeout(t, e);
}
function ke() {
  return Date.now();
}
function wi(t) {
  const e = Z();
  let i;
  return (
    e.getComputedStyle && (i = e.getComputedStyle(t, null)),
    !i && t.currentStyle && (i = t.currentStyle),
    i || (i = t.style),
    i
  );
}
function bi(t, e = "x") {
  const i = Z();
  let r, s, n;
  const o = wi(t);
  return (
    i.WebKitCSSMatrix
      ? ((s = o.transform || o.webkitTransform),
        s.split(",").length > 6 &&
          (s = s
            .split(", ")
            .map((c) => c.replace(",", "."))
            .join(", ")),
        (n = new i.WebKitCSSMatrix(s === "none" ? "" : s)))
      : ((n =
          o.MozTransform ||
          o.OTransform ||
          o.MsTransform ||
          o.msTransform ||
          o.transform ||
          o
            .getPropertyValue("transform")
            .replace("translate(", "matrix(1, 0, 0, 1,")),
        (r = n.toString().split(","))),
    e === "x" &&
      (i.WebKitCSSMatrix
        ? (s = n.m41)
        : r.length === 16
          ? (s = parseFloat(r[12]))
          : (s = parseFloat(r[4]))),
    e === "y" &&
      (i.WebKitCSSMatrix
        ? (s = n.m42)
        : r.length === 16
          ? (s = parseFloat(r[13]))
          : (s = parseFloat(r[5]))),
    s || 0
  );
}
function Pe(t) {
  return (
    typeof t == "object" &&
    t !== null &&
    t.constructor &&
    Object.prototype.toString.call(t).slice(8, -1) === "Object"
  );
}
function xi(t) {
  return typeof window < "u" && typeof window.HTMLElement < "u"
    ? t instanceof HTMLElement
    : t && (t.nodeType === 1 || t.nodeType === 11);
}
function ie(...t) {
  const e = Object(t[0]),
    i = ["__proto__", "constructor", "prototype"];
  for (let r = 1; r < t.length; r += 1) {
    const s = t[r];
    if (s != null && !xi(s)) {
      const n = Object.keys(Object(s)).filter((o) => i.indexOf(o) < 0);
      for (let o = 0, c = n.length; o < c; o += 1) {
        const a = n[o],
          d = Object.getOwnPropertyDescriptor(s, a);
        d !== void 0 &&
          d.enumerable &&
          (Pe(e[a]) && Pe(s[a])
            ? s[a].__swiper__
              ? (e[a] = s[a])
              : ie(e[a], s[a])
            : !Pe(e[a]) && Pe(s[a])
              ? ((e[a] = {}), s[a].__swiper__ ? (e[a] = s[a]) : ie(e[a], s[a]))
              : (e[a] = s[a]));
      }
    }
  }
  return e;
}
function Me(t, e, i) {
  t.style.setProperty(e, i);
}
function Ft({ swiper: t, targetPosition: e, side: i }) {
  const r = Z(),
    s = -t.translate;
  let n = null,
    o;
  const c = t.params.speed;
  ((t.wrapperEl.style.scrollSnapType = "none"),
    r.cancelAnimationFrame(t.cssModeFrameID));
  const a = e > s ? "next" : "prev",
    d = (f, g) => (a === "next" && f >= g) || (a === "prev" && f <= g),
    m = () => {
      ((o = new Date().getTime()), n === null && (n = o));
      const f = Math.max(Math.min((o - n) / c, 1), 0),
        g = 0.5 - Math.cos(f * Math.PI) / 2;
      let p = s + g * (e - s);
      if ((d(p, e) && (p = e), t.wrapperEl.scrollTo({ [i]: p }), d(p, e))) {
        ((t.wrapperEl.style.overflow = "hidden"),
          (t.wrapperEl.style.scrollSnapType = ""),
          setTimeout(() => {
            ((t.wrapperEl.style.overflow = ""),
              t.wrapperEl.scrollTo({ [i]: p }));
          }),
          r.cancelAnimationFrame(t.cssModeFrameID));
        return;
      }
      t.cssModeFrameID = r.requestAnimationFrame(m);
    };
  m();
}
function le(t, e = "") {
  const i = Z(),
    r = [...t.children];
  return (
    i.HTMLSlotElement &&
      t instanceof HTMLSlotElement &&
      r.push(...t.assignedElements()),
    e ? r.filter((s) => s.matches(e)) : r
  );
}
function yi(t, e) {
  const i = [e];
  for (; i.length > 0; ) {
    const r = i.shift();
    if (t === r) return !0;
    i.push(
      ...r.children,
      ...(r.shadowRoot ? r.shadowRoot.children : []),
      ...(r.assignedElements ? r.assignedElements() : []),
    );
  }
}
function Ti(t, e) {
  const i = Z();
  let r = e.contains(t);
  return (
    !r &&
      i.HTMLSlotElement &&
      e instanceof HTMLSlotElement &&
      ((r = [...e.assignedElements()].includes(t)), r || (r = yi(t, e))),
    r
  );
}
function Ie(t) {
  try {
    console.warn(t);
    return;
  } catch {}
}
function Je(t, e = []) {
  const i = document.createElement(t);
  return (i.classList.add(...(Array.isArray(e) ? e : vi(e))), i);
}
function Ei(t, e) {
  const i = [];
  for (; t.previousElementSibling; ) {
    const r = t.previousElementSibling;
    (e ? r.matches(e) && i.push(r) : i.push(r), (t = r));
  }
  return i;
}
function Ci(t, e) {
  const i = [];
  for (; t.nextElementSibling; ) {
    const r = t.nextElementSibling;
    (e ? r.matches(e) && i.push(r) : i.push(r), (t = r));
  }
  return i;
}
function ue(t, e) {
  return Z().getComputedStyle(t, null).getPropertyValue(e);
}
function St(t) {
  let e = t,
    i;
  if (e) {
    for (i = 0; (e = e.previousSibling) !== null; )
      e.nodeType === 1 && (i += 1);
    return i;
  }
}
function Pi(t, e) {
  const i = [];
  let r = t.parentElement;
  for (; r; ) (i.push(r), (r = r.parentElement));
  return i;
}
function wt(t, e, i) {
  const r = Z();
  return (
    t[e === "width" ? "offsetWidth" : "offsetHeight"] +
    parseFloat(
      r
        .getComputedStyle(t, null)
        .getPropertyValue(e === "width" ? "margin-right" : "margin-top"),
    ) +
    parseFloat(
      r
        .getComputedStyle(t, null)
        .getPropertyValue(e === "width" ? "margin-left" : "margin-bottom"),
    )
  );
}
let $e;
function Mi() {
  const t = Z(),
    e = me();
  return {
    smoothScroll:
      e.documentElement &&
      e.documentElement.style &&
      "scrollBehavior" in e.documentElement.style,
    touch: !!(
      "ontouchstart" in t ||
      (t.DocumentTouch && e instanceof t.DocumentTouch)
    ),
  };
}
function Ht() {
  return ($e || ($e = Mi()), $e);
}
let We;
function Li({ userAgent: t } = {}) {
  const e = Ht(),
    i = Z(),
    r = i.navigator.platform,
    s = t || i.navigator.userAgent,
    n = { ios: !1, android: !1 },
    o = i.screen.width,
    c = i.screen.height,
    a = s.match(/(Android);?[\s\/]+([\d.]+)?/);
  let d = s.match(/(iPad)(?!\1).*OS\s([\d_]+)/);
  const m = s.match(/(iPod)(.*OS\s([\d_]+))?/),
    f = !d && s.match(/(iPhone\sOS|iOS)\s([\d_]+)/),
    g = r === "Win32";
  let p = r === "MacIntel";
  const w = [
    "1024x1366",
    "1366x1024",
    "834x1194",
    "1194x834",
    "834x1112",
    "1112x834",
    "768x1024",
    "1024x768",
    "820x1180",
    "1180x820",
    "810x1080",
    "1080x810",
  ];
  return (
    !d &&
      p &&
      e.touch &&
      w.indexOf(`${o}x${c}`) >= 0 &&
      ((d = s.match(/(Version)\/([\d.]+)/)),
      d || (d = [0, 1, "13_0_0"]),
      (p = !1)),
    a && !g && ((n.os = "android"), (n.android = !0)),
    (d || f || m) && ((n.os = "ios"), (n.ios = !0)),
    n
  );
}
function Nt(t = {}) {
  return (We || (We = Li(t)), We);
}
let Ue;
function Ai() {
  const t = Z(),
    e = Nt();
  let i = !1;
  function r() {
    const c = t.navigator.userAgent.toLowerCase();
    return (
      c.indexOf("safari") >= 0 &&
      c.indexOf("chrome") < 0 &&
      c.indexOf("android") < 0
    );
  }
  if (r()) {
    const c = String(t.navigator.userAgent);
    if (c.includes("Version/")) {
      const [a, d] = c
        .split("Version/")[1]
        .split(" ")[0]
        .split(".")
        .map((m) => Number(m));
      i = a < 16 || (a === 16 && d < 2);
    }
  }
  const s = /(iPhone|iPod|iPad).*AppleWebKit(?!.*Safari)/i.test(
      t.navigator.userAgent,
    ),
    n = r(),
    o = n || (s && e.ios);
  return {
    isSafari: i || n,
    needPerspectiveFix: i,
    need3dFix: o,
    isWebView: s,
  };
}
function Rt() {
  return (Ue || (Ue = Ai()), Ue);
}
function ki({ swiper: t, on: e, emit: i }) {
  const r = Z();
  let s = null,
    n = null;
  const o = () => {
      !t || t.destroyed || !t.initialized || (i("beforeResize"), i("resize"));
    },
    c = () => {
      !t ||
        t.destroyed ||
        !t.initialized ||
        ((s = new ResizeObserver((m) => {
          n = r.requestAnimationFrame(() => {
            const { width: f, height: g } = t;
            let p = f,
              w = g;
            (m.forEach(({ contentBoxSize: S, contentRect: L, target: I }) => {
              (I && I !== t.el) ||
                ((p = L ? L.width : (S[0] || S).inlineSize),
                (w = L ? L.height : (S[0] || S).blockSize));
            }),
              (p !== f || w !== g) && o());
          });
        })),
        s.observe(t.el));
    },
    a = () => {
      (n && r.cancelAnimationFrame(n),
        s && s.unobserve && t.el && (s.unobserve(t.el), (s = null)));
    },
    d = () => {
      !t || t.destroyed || !t.initialized || i("orientationchange");
    };
  (e("init", () => {
    if (t.params.resizeObserver && typeof r.ResizeObserver < "u") {
      c();
      return;
    }
    (r.addEventListener("resize", o),
      r.addEventListener("orientationchange", d));
  }),
    e("destroy", () => {
      (a(),
        r.removeEventListener("resize", o),
        r.removeEventListener("orientationchange", d));
    }));
}
function Ii({ swiper: t, extendParams: e, on: i, emit: r }) {
  const s = [],
    n = Z(),
    o = (d, m = {}) => {
      const f = n.MutationObserver || n.WebkitMutationObserver,
        g = new f((p) => {
          if (t.__preventObserver__) return;
          if (p.length === 1) {
            r("observerUpdate", p[0]);
            return;
          }
          const w = function () {
            r("observerUpdate", p[0]);
          };
          n.requestAnimationFrame
            ? n.requestAnimationFrame(w)
            : n.setTimeout(w, 0);
        });
      (g.observe(d, {
        attributes: typeof m.attributes > "u" ? !0 : m.attributes,
        childList: t.isElement || (typeof m.childList > "u" ? !0 : m).childList,
        characterData: typeof m.characterData > "u" ? !0 : m.characterData,
      }),
        s.push(g));
    },
    c = () => {
      if (t.params.observer) {
        if (t.params.observeParents) {
          const d = Pi(t.hostEl);
          for (let m = 0; m < d.length; m += 1) o(d[m]);
        }
        (o(t.hostEl, { childList: t.params.observeSlideChildren }),
          o(t.wrapperEl, { attributes: !1 }));
      }
    },
    a = () => {
      (s.forEach((d) => {
        d.disconnect();
      }),
        s.splice(0, s.length));
    };
  (e({ observer: !1, observeParents: !1, observeSlideChildren: !1 }),
    i("init", c),
    i("destroy", a));
}
var Oi = {
  on(t, e, i) {
    const r = this;
    if (!r.eventsListeners || r.destroyed || typeof e != "function") return r;
    const s = i ? "unshift" : "push";
    return (
      t.split(" ").forEach((n) => {
        (r.eventsListeners[n] || (r.eventsListeners[n] = []),
          r.eventsListeners[n][s](e));
      }),
      r
    );
  },
  once(t, e, i) {
    const r = this;
    if (!r.eventsListeners || r.destroyed || typeof e != "function") return r;
    function s(...n) {
      (r.off(t, s), s.__emitterProxy && delete s.__emitterProxy, e.apply(r, n));
    }
    return ((s.__emitterProxy = e), r.on(t, s, i));
  },
  onAny(t, e) {
    const i = this;
    if (!i.eventsListeners || i.destroyed || typeof t != "function") return i;
    const r = e ? "unshift" : "push";
    return (
      i.eventsAnyListeners.indexOf(t) < 0 && i.eventsAnyListeners[r](t),
      i
    );
  },
  offAny(t) {
    const e = this;
    if (!e.eventsListeners || e.destroyed || !e.eventsAnyListeners) return e;
    const i = e.eventsAnyListeners.indexOf(t);
    return (i >= 0 && e.eventsAnyListeners.splice(i, 1), e);
  },
  off(t, e) {
    const i = this;
    return (
      !i.eventsListeners ||
        i.destroyed ||
        !i.eventsListeners ||
        t.split(" ").forEach((r) => {
          typeof e > "u"
            ? (i.eventsListeners[r] = [])
            : i.eventsListeners[r] &&
              i.eventsListeners[r].forEach((s, n) => {
                (s === e || (s.__emitterProxy && s.__emitterProxy === e)) &&
                  i.eventsListeners[r].splice(n, 1);
              });
        }),
      i
    );
  },
  emit(...t) {
    const e = this;
    if (!e.eventsListeners || e.destroyed || !e.eventsListeners) return e;
    let i, r, s;
    return (
      typeof t[0] == "string" || Array.isArray(t[0])
        ? ((i = t[0]), (r = t.slice(1, t.length)), (s = e))
        : ((i = t[0].events), (r = t[0].data), (s = t[0].context || e)),
      r.unshift(s),
      (Array.isArray(i) ? i : i.split(" ")).forEach((o) => {
        (e.eventsAnyListeners &&
          e.eventsAnyListeners.length &&
          e.eventsAnyListeners.forEach((c) => {
            c.apply(s, [o, ...r]);
          }),
          e.eventsListeners &&
            e.eventsListeners[o] &&
            e.eventsListeners[o].forEach((c) => {
              c.apply(s, r);
            }));
      }),
      e
    );
  },
};
function _i() {
  const t = this;
  let e, i;
  const r = t.el;
  (typeof t.params.width < "u" && t.params.width !== null
    ? (e = t.params.width)
    : (e = r.clientWidth),
    typeof t.params.height < "u" && t.params.height !== null
      ? (i = t.params.height)
      : (i = r.clientHeight),
    !((e === 0 && t.isHorizontal()) || (i === 0 && t.isVertical())) &&
      ((e =
        e -
        parseInt(ue(r, "padding-left") || 0, 10) -
        parseInt(ue(r, "padding-right") || 0, 10)),
      (i =
        i -
        parseInt(ue(r, "padding-top") || 0, 10) -
        parseInt(ue(r, "padding-bottom") || 0, 10)),
      Number.isNaN(e) && (e = 0),
      Number.isNaN(i) && (i = 0),
      Object.assign(t, {
        width: e,
        height: i,
        size: t.isHorizontal() ? e : i,
      })));
}
function Vi() {
  const t = this;
  function e(A, M) {
    return parseFloat(A.getPropertyValue(t.getDirectionLabel(M)) || 0);
  }
  const i = t.params,
    { wrapperEl: r, slidesEl: s, rtlTranslate: n, wrongRTL: o } = t,
    c = t.virtual && i.virtual.enabled,
    a = c ? t.virtual.slides.length : t.slides.length,
    d = le(s, `.${t.params.slideClass}, swiper-slide`),
    m = c ? t.virtual.slides.length : d.length;
  let f = [];
  const g = [],
    p = [];
  let w = i.slidesOffsetBefore;
  typeof w == "function" && (w = i.slidesOffsetBefore.call(t));
  let S = i.slidesOffsetAfter;
  typeof S == "function" && (S = i.slidesOffsetAfter.call(t));
  const L = t.snapGrid.length,
    I = t.slidesGrid.length,
    y = t.size - w - S;
  let E = i.spaceBetween,
    O = -w,
    P = 0,
    D = 0;
  if (typeof y > "u") return;
  (typeof E == "string" && E.indexOf("%") >= 0
    ? (E = (parseFloat(E.replace("%", "")) / 100) * y)
    : typeof E == "string" && (E = parseFloat(E)),
    (t.virtualSize = -E - w - S),
    d.forEach((A) => {
      (n ? (A.style.marginLeft = "") : (A.style.marginRight = ""),
        (A.style.marginBottom = ""),
        (A.style.marginTop = ""));
    }),
    i.centeredSlides &&
      i.cssMode &&
      (Me(r, "--swiper-centered-offset-before", ""),
      Me(r, "--swiper-centered-offset-after", "")));
  const z = i.grid && i.grid.rows > 1 && t.grid;
  z ? t.grid.initSlides(d) : t.grid && t.grid.unsetSlides();
  let C;
  const $ =
    i.slidesPerView === "auto" &&
    i.breakpoints &&
    Object.keys(i.breakpoints).filter(
      (A) => typeof i.breakpoints[A].slidesPerView < "u",
    ).length > 0;
  for (let A = 0; A < m; A += 1) {
    C = 0;
    const M = d[A];
    if (
      !(M && (z && t.grid.updateSlide(A, M, d), ue(M, "display") === "none"))
    ) {
      if (c && i.slidesPerView === "auto")
        (i.virtual.slidesPerViewAutoSlideSize &&
          (C = i.virtual.slidesPerViewAutoSlideSize),
          C &&
            M &&
            (i.roundLengths && (C = Math.floor(C)),
            (M.style[t.getDirectionLabel("width")] = `${C}px`)));
      else if (i.slidesPerView === "auto") {
        $ && (M.style[t.getDirectionLabel("width")] = "");
        const V = getComputedStyle(M),
          X = M.style.transform,
          ee = M.style.webkitTransform;
        if (
          (X && (M.style.transform = "none"),
          ee && (M.style.webkitTransform = "none"),
          i.roundLengths)
        )
          C = t.isHorizontal() ? wt(M, "width") : wt(M, "height");
        else {
          const te = e(V, "width"),
            xe = e(V, "padding-left"),
            oe = e(V, "padding-right"),
            _ = e(V, "margin-left"),
            j = e(V, "margin-right"),
            Y = V.getPropertyValue("box-sizing");
          if (Y && Y === "border-box") C = te + _ + j;
          else {
            const { clientWidth: ne, offsetWidth: ye } = M;
            C = te + xe + oe + _ + j + (ye - ne);
          }
        }
        (X && (M.style.transform = X),
          ee && (M.style.webkitTransform = ee),
          i.roundLengths && (C = Math.floor(C)));
      } else
        ((C = (y - (i.slidesPerView - 1) * E) / i.slidesPerView),
          i.roundLengths && (C = Math.floor(C)),
          M && (M.style[t.getDirectionLabel("width")] = `${C}px`));
      (M && (M.swiperSlideSize = C),
        p.push(C),
        i.centeredSlides
          ? ((O = O + C / 2 + P / 2 + E),
            P === 0 && A !== 0 && (O = O - y / 2 - E),
            A === 0 && (O = O - y / 2 - E),
            Math.abs(O) < 1 / 1e3 && (O = 0),
            i.roundLengths && (O = Math.floor(O)),
            D % i.slidesPerGroup === 0 && f.push(O),
            g.push(O))
          : (i.roundLengths && (O = Math.floor(O)),
            (D - Math.min(t.params.slidesPerGroupSkip, D)) %
              t.params.slidesPerGroup ===
              0 && f.push(O),
            g.push(O),
            (O = O + C + E)),
        (t.virtualSize += C + E),
        (P = C),
        (D += 1));
    }
  }
  if (
    ((t.virtualSize = Math.max(t.virtualSize, y) + S),
    n &&
      o &&
      (i.effect === "slide" || i.effect === "coverflow") &&
      (r.style.width = `${t.virtualSize + E}px`),
    i.setWrapperSize &&
      (r.style[t.getDirectionLabel("width")] = `${t.virtualSize + E}px`),
    z && t.grid.updateWrapperSize(C, f),
    !i.centeredSlides)
  ) {
    const A = [];
    for (let M = 0; M < f.length; M += 1) {
      let V = f[M];
      (i.roundLengths && (V = Math.floor(V)),
        f[M] <= t.virtualSize - y && A.push(V));
    }
    ((f = A),
      Math.floor(t.virtualSize - y) - Math.floor(f[f.length - 1]) > 1 &&
        f.push(t.virtualSize - y));
  }
  if (c && i.loop) {
    const A = p[0] + E;
    if (i.slidesPerGroup > 1) {
      const M = Math.ceil(
          (t.virtual.slidesBefore + t.virtual.slidesAfter) / i.slidesPerGroup,
        ),
        V = A * i.slidesPerGroup;
      for (let X = 0; X < M; X += 1) f.push(f[f.length - 1] + V);
    }
    for (let M = 0; M < t.virtual.slidesBefore + t.virtual.slidesAfter; M += 1)
      (i.slidesPerGroup === 1 && f.push(f[f.length - 1] + A),
        g.push(g[g.length - 1] + A),
        (t.virtualSize += A));
  }
  if ((f.length === 0 && (f = [0]), E !== 0)) {
    const A =
      t.isHorizontal() && n ? "marginLeft" : t.getDirectionLabel("marginRight");
    d.filter((M, V) =>
      !i.cssMode || i.loop ? !0 : V !== d.length - 1,
    ).forEach((M) => {
      M.style[A] = `${E}px`;
    });
  }
  if (i.centeredSlides && i.centeredSlidesBounds) {
    let A = 0;
    (p.forEach((V) => {
      A += V + (E || 0);
    }),
      (A -= E));
    const M = A > y ? A - y : 0;
    f = f.map((V) => (V <= 0 ? -w : V > M ? M + S : V));
  }
  if (i.centerInsufficientSlides) {
    let A = 0;
    (p.forEach((V) => {
      A += V + (E || 0);
    }),
      (A -= E));
    const M = (w || 0) + (S || 0);
    if (A + M < y) {
      const V = (y - A - M) / 2;
      (f.forEach((X, ee) => {
        f[ee] = X - V;
      }),
        g.forEach((X, ee) => {
          g[ee] = X + V;
        }));
    }
  }
  if (
    (Object.assign(t, {
      slides: d,
      snapGrid: f,
      slidesGrid: g,
      slidesSizesGrid: p,
    }),
    i.centeredSlides && i.cssMode && !i.centeredSlidesBounds)
  ) {
    (Me(r, "--swiper-centered-offset-before", `${-f[0]}px`),
      Me(
        r,
        "--swiper-centered-offset-after",
        `${t.size / 2 - p[p.length - 1] / 2}px`,
      ));
    const A = -t.snapGrid[0],
      M = -t.slidesGrid[0];
    ((t.snapGrid = t.snapGrid.map((V) => V + A)),
      (t.slidesGrid = t.slidesGrid.map((V) => V + M)));
  }
  if (
    (m !== a && t.emit("slidesLengthChange"),
    f.length !== L &&
      (t.params.watchOverflow && t.checkOverflow(),
      t.emit("snapGridLengthChange")),
    g.length !== I && t.emit("slidesGridLengthChange"),
    i.watchSlidesProgress && t.updateSlidesOffset(),
    t.emit("slidesUpdated"),
    !c && !i.cssMode && (i.effect === "slide" || i.effect === "fade"))
  ) {
    const A = `${i.containerModifierClass}backface-hidden`,
      M = t.el.classList.contains(A);
    m <= i.maxBackfaceHiddenSlides
      ? M || t.el.classList.add(A)
      : M && t.el.classList.remove(A);
  }
}
function zi(t) {
  const e = this,
    i = [],
    r = e.virtual && e.params.virtual.enabled;
  let s = 0,
    n;
  typeof t == "number"
    ? e.setTransition(t)
    : t === !0 && e.setTransition(e.params.speed);
  const o = (c) => (r ? e.slides[e.getSlideIndexByData(c)] : e.slides[c]);
  if (e.params.slidesPerView !== "auto" && e.params.slidesPerView > 1)
    if (e.params.centeredSlides)
      (e.visibleSlides || []).forEach((c) => {
        i.push(c);
      });
    else
      for (n = 0; n < Math.ceil(e.params.slidesPerView); n += 1) {
        const c = e.activeIndex + n;
        if (c > e.slides.length && !r) break;
        i.push(o(c));
      }
  else i.push(o(e.activeIndex));
  for (n = 0; n < i.length; n += 1)
    if (typeof i[n] < "u") {
      const c = i[n].offsetHeight;
      s = c > s ? c : s;
    }
  (s || s === 0) && (e.wrapperEl.style.height = `${s}px`);
}
function Di() {
  const t = this,
    e = t.slides,
    i = t.isElement
      ? t.isHorizontal()
        ? t.wrapperEl.offsetLeft
        : t.wrapperEl.offsetTop
      : 0;
  for (let r = 0; r < e.length; r += 1)
    e[r].swiperSlideOffset =
      (t.isHorizontal() ? e[r].offsetLeft : e[r].offsetTop) -
      i -
      t.cssOverflowAdjustment();
}
const bt = (t, e, i) => {
  e && !t.classList.contains(i)
    ? t.classList.add(i)
    : !e && t.classList.contains(i) && t.classList.remove(i);
};
function Gi(t = (this && this.translate) || 0) {
  const e = this,
    i = e.params,
    { slides: r, rtlTranslate: s, snapGrid: n } = e;
  if (r.length === 0) return;
  typeof r[0].swiperSlideOffset > "u" && e.updateSlidesOffset();
  let o = -t;
  (s && (o = t), (e.visibleSlidesIndexes = []), (e.visibleSlides = []));
  let c = i.spaceBetween;
  typeof c == "string" && c.indexOf("%") >= 0
    ? (c = (parseFloat(c.replace("%", "")) / 100) * e.size)
    : typeof c == "string" && (c = parseFloat(c));
  for (let a = 0; a < r.length; a += 1) {
    const d = r[a];
    let m = d.swiperSlideOffset;
    i.cssMode && i.centeredSlides && (m -= r[0].swiperSlideOffset);
    const f =
        (o + (i.centeredSlides ? e.minTranslate() : 0) - m) /
        (d.swiperSlideSize + c),
      g =
        (o - n[0] + (i.centeredSlides ? e.minTranslate() : 0) - m) /
        (d.swiperSlideSize + c),
      p = -(o - m),
      w = p + e.slidesSizesGrid[a],
      S = p >= 0 && p <= e.size - e.slidesSizesGrid[a],
      L =
        (p >= 0 && p < e.size - 1) ||
        (w > 1 && w <= e.size) ||
        (p <= 0 && w >= e.size);
    (L && (e.visibleSlides.push(d), e.visibleSlidesIndexes.push(a)),
      bt(d, L, i.slideVisibleClass),
      bt(d, S, i.slideFullyVisibleClass),
      (d.progress = s ? -f : f),
      (d.originalProgress = s ? -g : g));
  }
}
function Bi(t) {
  const e = this;
  if (typeof t > "u") {
    const m = e.rtlTranslate ? -1 : 1;
    t = (e && e.translate && e.translate * m) || 0;
  }
  const i = e.params,
    r = e.maxTranslate() - e.minTranslate();
  let { progress: s, isBeginning: n, isEnd: o, progressLoop: c } = e;
  const a = n,
    d = o;
  if (r === 0) ((s = 0), (n = !0), (o = !0));
  else {
    s = (t - e.minTranslate()) / r;
    const m = Math.abs(t - e.minTranslate()) < 1,
      f = Math.abs(t - e.maxTranslate()) < 1;
    ((n = m || s <= 0), (o = f || s >= 1), m && (s = 0), f && (s = 1));
  }
  if (i.loop) {
    const m = e.getSlideIndexByData(0),
      f = e.getSlideIndexByData(e.slides.length - 1),
      g = e.slidesGrid[m],
      p = e.slidesGrid[f],
      w = e.slidesGrid[e.slidesGrid.length - 1],
      S = Math.abs(t);
    (S >= g ? (c = (S - g) / w) : (c = (S + w - p) / w), c > 1 && (c -= 1));
  }
  (Object.assign(e, { progress: s, progressLoop: c, isBeginning: n, isEnd: o }),
    (i.watchSlidesProgress || (i.centeredSlides && i.autoHeight)) &&
      e.updateSlidesProgress(t),
    n && !a && e.emit("reachBeginning toEdge"),
    o && !d && e.emit("reachEnd toEdge"),
    ((a && !n) || (d && !o)) && e.emit("fromEdge"),
    e.emit("progress", s));
}
const Xe = (t, e, i) => {
  e && !t.classList.contains(i)
    ? t.classList.add(i)
    : !e && t.classList.contains(i) && t.classList.remove(i);
};
function Fi() {
  const t = this,
    { slides: e, params: i, slidesEl: r, activeIndex: s } = t,
    n = t.virtual && i.virtual.enabled,
    o = t.grid && i.grid && i.grid.rows > 1,
    c = (f) => le(r, `.${i.slideClass}${f}, swiper-slide${f}`)[0];
  let a, d, m;
  if (n)
    if (i.loop) {
      let f = s - t.virtual.slidesBefore;
      (f < 0 && (f = t.virtual.slides.length + f),
        f >= t.virtual.slides.length && (f -= t.virtual.slides.length),
        (a = c(`[data-swiper-slide-index="${f}"]`)));
    } else a = c(`[data-swiper-slide-index="${s}"]`);
  else
    o
      ? ((a = e.find((f) => f.column === s)),
        (m = e.find((f) => f.column === s + 1)),
        (d = e.find((f) => f.column === s - 1)))
      : (a = e[s]);
  (a &&
    (o ||
      ((m = Ci(a, `.${i.slideClass}, swiper-slide`)[0]),
      i.loop && !m && (m = e[0]),
      (d = Ei(a, `.${i.slideClass}, swiper-slide`)[0]),
      i.loop && !d === 0 && (d = e[e.length - 1]))),
    e.forEach((f) => {
      (Xe(f, f === a, i.slideActiveClass),
        Xe(f, f === m, i.slideNextClass),
        Xe(f, f === d, i.slidePrevClass));
    }),
    t.emitSlidesClasses());
}
const Le = (t, e) => {
    if (!t || t.destroyed || !t.params) return;
    const i = () => (t.isElement ? "swiper-slide" : `.${t.params.slideClass}`),
      r = e.closest(i());
    if (r) {
      let s = r.querySelector(`.${t.params.lazyPreloaderClass}`);
      (!s &&
        t.isElement &&
        (r.shadowRoot
          ? (s = r.shadowRoot.querySelector(`.${t.params.lazyPreloaderClass}`))
          : requestAnimationFrame(() => {
              r.shadowRoot &&
                ((s = r.shadowRoot.querySelector(
                  `.${t.params.lazyPreloaderClass}`,
                )),
                s && s.remove());
            })),
        s && s.remove());
    }
  },
  Ye = (t, e) => {
    if (!t.slides[e]) return;
    const i = t.slides[e].querySelector('[loading="lazy"]');
    i && i.removeAttribute("loading");
  },
  Ze = (t) => {
    if (!t || t.destroyed || !t.params) return;
    let e = t.params.lazyPreloadPrevNext;
    const i = t.slides.length;
    if (!i || !e || e < 0) return;
    e = Math.min(e, i);
    const r =
        t.params.slidesPerView === "auto"
          ? t.slidesPerViewDynamic()
          : Math.ceil(t.params.slidesPerView),
      s = t.activeIndex;
    if (t.params.grid && t.params.grid.rows > 1) {
      const o = s,
        c = [o - e];
      (c.push(...Array.from({ length: e }).map((a, d) => o + r + d)),
        t.slides.forEach((a, d) => {
          c.includes(a.column) && Ye(t, d);
        }));
      return;
    }
    const n = s + r - 1;
    if (t.params.rewind || t.params.loop)
      for (let o = s - e; o <= n + e; o += 1) {
        const c = ((o % i) + i) % i;
        (c < s || c > n) && Ye(t, c);
      }
    else
      for (let o = Math.max(s - e, 0); o <= Math.min(n + e, i - 1); o += 1)
        o !== s && (o > n || o < s) && Ye(t, o);
  };
function Hi(t) {
  const { slidesGrid: e, params: i } = t,
    r = t.rtlTranslate ? t.translate : -t.translate;
  let s;
  for (let n = 0; n < e.length; n += 1)
    typeof e[n + 1] < "u"
      ? r >= e[n] && r < e[n + 1] - (e[n + 1] - e[n]) / 2
        ? (s = n)
        : r >= e[n] && r < e[n + 1] && (s = n + 1)
      : r >= e[n] && (s = n);
  return (i.normalizeSlideIndex && (s < 0 || typeof s > "u") && (s = 0), s);
}
function Ni(t) {
  const e = this,
    i = e.rtlTranslate ? e.translate : -e.translate,
    { snapGrid: r, params: s, activeIndex: n, realIndex: o, snapIndex: c } = e;
  let a = t,
    d;
  const m = (p) => {
    let w = p - e.virtual.slidesBefore;
    return (
      w < 0 && (w = e.virtual.slides.length + w),
      w >= e.virtual.slides.length && (w -= e.virtual.slides.length),
      w
    );
  };
  if ((typeof a > "u" && (a = Hi(e)), r.indexOf(i) >= 0)) d = r.indexOf(i);
  else {
    const p = Math.min(s.slidesPerGroupSkip, a);
    d = p + Math.floor((a - p) / s.slidesPerGroup);
  }
  if ((d >= r.length && (d = r.length - 1), a === n && !e.params.loop)) {
    d !== c && ((e.snapIndex = d), e.emit("snapIndexChange"));
    return;
  }
  if (a === n && e.params.loop && e.virtual && e.params.virtual.enabled) {
    e.realIndex = m(a);
    return;
  }
  const f = e.grid && s.grid && s.grid.rows > 1;
  let g;
  if (e.virtual && s.virtual.enabled && s.loop) g = m(a);
  else if (f) {
    const p = e.slides.find((S) => S.column === a);
    let w = parseInt(p.getAttribute("data-swiper-slide-index"), 10);
    (Number.isNaN(w) && (w = Math.max(e.slides.indexOf(p), 0)),
      (g = Math.floor(w / s.grid.rows)));
  } else if (e.slides[a]) {
    const p = e.slides[a].getAttribute("data-swiper-slide-index");
    p ? (g = parseInt(p, 10)) : (g = a);
  } else g = a;
  (Object.assign(e, {
    previousSnapIndex: c,
    snapIndex: d,
    previousRealIndex: o,
    realIndex: g,
    previousIndex: n,
    activeIndex: a,
  }),
    e.initialized && Ze(e),
    e.emit("activeIndexChange"),
    e.emit("snapIndexChange"),
    (e.initialized || e.params.runCallbacksOnInit) &&
      (o !== g && e.emit("realIndexChange"), e.emit("slideChange")));
}
function Ri(t, e) {
  const i = this,
    r = i.params;
  let s = t.closest(`.${r.slideClass}, swiper-slide`);
  !s &&
    i.isElement &&
    e &&
    e.length > 1 &&
    e.includes(t) &&
    [...e.slice(e.indexOf(t) + 1, e.length)].forEach((c) => {
      !s && c.matches && c.matches(`.${r.slideClass}, swiper-slide`) && (s = c);
    });
  let n = !1,
    o;
  if (s) {
    for (let c = 0; c < i.slides.length; c += 1)
      if (i.slides[c] === s) {
        ((n = !0), (o = c));
        break;
      }
  }
  if (s && n)
    ((i.clickedSlide = s),
      i.virtual && i.params.virtual.enabled
        ? (i.clickedIndex = parseInt(
            s.getAttribute("data-swiper-slide-index"),
            10,
          ))
        : (i.clickedIndex = o));
  else {
    ((i.clickedSlide = void 0), (i.clickedIndex = void 0));
    return;
  }
  r.slideToClickedSlide &&
    i.clickedIndex !== void 0 &&
    i.clickedIndex !== i.activeIndex &&
    i.slideToClickedSlide();
}
var ji = {
  updateSize: _i,
  updateSlides: Vi,
  updateAutoHeight: zi,
  updateSlidesOffset: Di,
  updateSlidesProgress: Gi,
  updateProgress: Bi,
  updateSlidesClasses: Fi,
  updateActiveIndex: Ni,
  updateClickedSlide: Ri,
};
function qi(t = this.isHorizontal() ? "x" : "y") {
  const e = this,
    { params: i, rtlTranslate: r, translate: s, wrapperEl: n } = e;
  if (i.virtualTranslate) return r ? -s : s;
  if (i.cssMode) return s;
  let o = bi(n, t);
  return ((o += e.cssOverflowAdjustment()), r && (o = -o), o || 0);
}
function $i(t, e) {
  const i = this,
    { rtlTranslate: r, params: s, wrapperEl: n, progress: o } = i;
  let c = 0,
    a = 0;
  const d = 0;
  (i.isHorizontal() ? (c = r ? -t : t) : (a = t),
    s.roundLengths && ((c = Math.floor(c)), (a = Math.floor(a))),
    (i.previousTranslate = i.translate),
    (i.translate = i.isHorizontal() ? c : a),
    s.cssMode
      ? (n[i.isHorizontal() ? "scrollLeft" : "scrollTop"] = i.isHorizontal()
          ? -c
          : -a)
      : s.virtualTranslate ||
        (i.isHorizontal()
          ? (c -= i.cssOverflowAdjustment())
          : (a -= i.cssOverflowAdjustment()),
        (n.style.transform = `translate3d(${c}px, ${a}px, ${d}px)`)));
  let m;
  const f = i.maxTranslate() - i.minTranslate();
  (f === 0 ? (m = 0) : (m = (t - i.minTranslate()) / f),
    m !== o && i.updateProgress(t),
    i.emit("setTranslate", i.translate, e));
}
function Wi() {
  return -this.snapGrid[0];
}
function Ui() {
  return -this.snapGrid[this.snapGrid.length - 1];
}
function Xi(t = 0, e = this.params.speed, i = !0, r = !0, s) {
  const n = this,
    { params: o, wrapperEl: c } = n;
  if (n.animating && o.preventInteractionOnTransition) return !1;
  const a = n.minTranslate(),
    d = n.maxTranslate();
  let m;
  if (
    (r && t > a ? (m = a) : r && t < d ? (m = d) : (m = t),
    n.updateProgress(m),
    o.cssMode)
  ) {
    const f = n.isHorizontal();
    if (e === 0) c[f ? "scrollLeft" : "scrollTop"] = -m;
    else {
      if (!n.support.smoothScroll)
        return (
          Ft({ swiper: n, targetPosition: -m, side: f ? "left" : "top" }),
          !0
        );
      c.scrollTo({ [f ? "left" : "top"]: -m, behavior: "smooth" });
    }
    return !0;
  }
  return (
    e === 0
      ? (n.setTransition(0),
        n.setTranslate(m),
        i && (n.emit("beforeTransitionStart", e, s), n.emit("transitionEnd")))
      : (n.setTransition(e),
        n.setTranslate(m),
        i && (n.emit("beforeTransitionStart", e, s), n.emit("transitionStart")),
        n.animating ||
          ((n.animating = !0),
          n.onTranslateToWrapperTransitionEnd ||
            (n.onTranslateToWrapperTransitionEnd = function (g) {
              !n ||
                n.destroyed ||
                (g.target === this &&
                  (n.wrapperEl.removeEventListener(
                    "transitionend",
                    n.onTranslateToWrapperTransitionEnd,
                  ),
                  (n.onTranslateToWrapperTransitionEnd = null),
                  delete n.onTranslateToWrapperTransitionEnd,
                  (n.animating = !1),
                  i && n.emit("transitionEnd")));
            }),
          n.wrapperEl.addEventListener(
            "transitionend",
            n.onTranslateToWrapperTransitionEnd,
          ))),
    !0
  );
}
var Yi = {
  getTranslate: qi,
  setTranslate: $i,
  minTranslate: Wi,
  maxTranslate: Ui,
  translateTo: Xi,
};
function Ki(t, e) {
  const i = this;
  (i.params.cssMode ||
    ((i.wrapperEl.style.transitionDuration = `${t}ms`),
    (i.wrapperEl.style.transitionDelay = t === 0 ? "0ms" : "")),
    i.emit("setTransition", t, e));
}
function jt({ swiper: t, runCallbacks: e, direction: i, step: r }) {
  const { activeIndex: s, previousIndex: n } = t;
  let o = i;
  (o || (s > n ? (o = "next") : s < n ? (o = "prev") : (o = "reset")),
    t.emit(`transition${r}`),
    e && o === "reset"
      ? t.emit(`slideResetTransition${r}`)
      : e &&
        s !== n &&
        (t.emit(`slideChangeTransition${r}`),
        o === "next"
          ? t.emit(`slideNextTransition${r}`)
          : t.emit(`slidePrevTransition${r}`)));
}
function Qi(t = !0, e) {
  const i = this,
    { params: r } = i;
  r.cssMode ||
    (r.autoHeight && i.updateAutoHeight(),
    jt({ swiper: i, runCallbacks: t, direction: e, step: "Start" }));
}
function Ji(t = !0, e) {
  const i = this,
    { params: r } = i;
  ((i.animating = !1),
    !r.cssMode &&
      (i.setTransition(0),
      jt({ swiper: i, runCallbacks: t, direction: e, step: "End" })));
}
var Zi = { setTransition: Ki, transitionStart: Qi, transitionEnd: Ji };
function er(t = 0, e, i = !0, r, s) {
  typeof t == "string" && (t = parseInt(t, 10));
  const n = this;
  let o = t;
  o < 0 && (o = 0);
  const {
    params: c,
    snapGrid: a,
    slidesGrid: d,
    previousIndex: m,
    activeIndex: f,
    rtlTranslate: g,
    wrapperEl: p,
    enabled: w,
  } = n;
  if (
    (!w && !r && !s) ||
    n.destroyed ||
    (n.animating && c.preventInteractionOnTransition)
  )
    return !1;
  typeof e > "u" && (e = n.params.speed);
  const S = Math.min(n.params.slidesPerGroupSkip, o);
  let L = S + Math.floor((o - S) / n.params.slidesPerGroup);
  L >= a.length && (L = a.length - 1);
  const I = -a[L];
  if (c.normalizeSlideIndex)
    for (let z = 0; z < d.length; z += 1) {
      const C = -Math.floor(I * 100),
        $ = Math.floor(d[z] * 100),
        A = Math.floor(d[z + 1] * 100);
      typeof d[z + 1] < "u"
        ? C >= $ && C < A - (A - $) / 2
          ? (o = z)
          : C >= $ && C < A && (o = z + 1)
        : C >= $ && (o = z);
    }
  if (
    n.initialized &&
    o !== f &&
    ((!n.allowSlideNext &&
      (g
        ? I > n.translate && I > n.minTranslate()
        : I < n.translate && I < n.minTranslate())) ||
      (!n.allowSlidePrev &&
        I > n.translate &&
        I > n.maxTranslate() &&
        (f || 0) !== o))
  )
    return !1;
  (o !== (m || 0) && i && n.emit("beforeSlideChangeStart"),
    n.updateProgress(I));
  let y;
  o > f ? (y = "next") : o < f ? (y = "prev") : (y = "reset");
  const E = n.virtual && n.params.virtual.enabled;
  if (!(E && s) && ((g && -I === n.translate) || (!g && I === n.translate)))
    return (
      n.updateActiveIndex(o),
      c.autoHeight && n.updateAutoHeight(),
      n.updateSlidesClasses(),
      c.effect !== "slide" && n.setTranslate(I),
      y !== "reset" && (n.transitionStart(i, y), n.transitionEnd(i, y)),
      !1
    );
  if (c.cssMode) {
    const z = n.isHorizontal(),
      C = g ? I : -I;
    if (e === 0)
      (E &&
        ((n.wrapperEl.style.scrollSnapType = "none"),
        (n._immediateVirtual = !0)),
        E && !n._cssModeVirtualInitialSet && n.params.initialSlide > 0
          ? ((n._cssModeVirtualInitialSet = !0),
            requestAnimationFrame(() => {
              p[z ? "scrollLeft" : "scrollTop"] = C;
            }))
          : (p[z ? "scrollLeft" : "scrollTop"] = C),
        E &&
          requestAnimationFrame(() => {
            ((n.wrapperEl.style.scrollSnapType = ""),
              (n._immediateVirtual = !1));
          }));
    else {
      if (!n.support.smoothScroll)
        return (
          Ft({ swiper: n, targetPosition: C, side: z ? "left" : "top" }),
          !0
        );
      p.scrollTo({ [z ? "left" : "top"]: C, behavior: "smooth" });
    }
    return !0;
  }
  const D = Rt().isSafari;
  return (
    E && !s && D && n.isElement && n.virtual.update(!1, !1, o),
    n.setTransition(e),
    n.setTranslate(I),
    n.updateActiveIndex(o),
    n.updateSlidesClasses(),
    n.emit("beforeTransitionStart", e, r),
    n.transitionStart(i, y),
    e === 0
      ? n.transitionEnd(i, y)
      : n.animating ||
        ((n.animating = !0),
        n.onSlideToWrapperTransitionEnd ||
          (n.onSlideToWrapperTransitionEnd = function (C) {
            !n ||
              n.destroyed ||
              (C.target === this &&
                (n.wrapperEl.removeEventListener(
                  "transitionend",
                  n.onSlideToWrapperTransitionEnd,
                ),
                (n.onSlideToWrapperTransitionEnd = null),
                delete n.onSlideToWrapperTransitionEnd,
                n.transitionEnd(i, y)));
          }),
        n.wrapperEl.addEventListener(
          "transitionend",
          n.onSlideToWrapperTransitionEnd,
        )),
    !0
  );
}
function tr(t = 0, e, i = !0, r) {
  typeof t == "string" && (t = parseInt(t, 10));
  const s = this;
  if (s.destroyed) return;
  typeof e > "u" && (e = s.params.speed);
  const n = s.grid && s.params.grid && s.params.grid.rows > 1;
  let o = t;
  if (s.params.loop)
    if (s.virtual && s.params.virtual.enabled) o = o + s.virtual.slidesBefore;
    else {
      let c;
      if (n) {
        const S = o * s.params.grid.rows;
        c = s.slides.find(
          (L) => L.getAttribute("data-swiper-slide-index") * 1 === S,
        ).column;
      } else c = s.getSlideIndexByData(o);
      const a = n
          ? Math.ceil(s.slides.length / s.params.grid.rows)
          : s.slides.length,
        {
          centeredSlides: d,
          slidesOffsetBefore: m,
          slidesOffsetAfter: f,
        } = s.params,
        g = d || !!m || !!f;
      let p = s.params.slidesPerView;
      p === "auto"
        ? (p = s.slidesPerViewDynamic())
        : ((p = Math.ceil(parseFloat(s.params.slidesPerView, 10))),
          g && p % 2 === 0 && (p = p + 1));
      let w = a - c < p;
      if (
        (g && (w = w || c < Math.ceil(p / 2)),
        r && g && s.params.slidesPerView !== "auto" && !n && (w = !1),
        w)
      ) {
        const S = g
          ? c < s.activeIndex
            ? "prev"
            : "next"
          : c - s.activeIndex - 1 < s.params.slidesPerView
            ? "next"
            : "prev";
        s.loopFix({
          direction: S,
          slideTo: !0,
          activeSlideIndex: S === "next" ? c + 1 : c - a + 1,
          slideRealIndex: S === "next" ? s.realIndex : void 0,
        });
      }
      if (n) {
        const S = o * s.params.grid.rows;
        o = s.slides.find(
          (L) => L.getAttribute("data-swiper-slide-index") * 1 === S,
        ).column;
      } else o = s.getSlideIndexByData(o);
    }
  return (
    requestAnimationFrame(() => {
      s.slideTo(o, e, i, r);
    }),
    s
  );
}
function ir(t, e = !0, i) {
  const r = this,
    { enabled: s, params: n, animating: o } = r;
  if (!s || r.destroyed) return r;
  typeof t > "u" && (t = r.params.speed);
  let c = n.slidesPerGroup;
  n.slidesPerView === "auto" &&
    n.slidesPerGroup === 1 &&
    n.slidesPerGroupAuto &&
    (c = Math.max(r.slidesPerViewDynamic("current", !0), 1));
  const a = r.activeIndex < n.slidesPerGroupSkip ? 1 : c,
    d = r.virtual && n.virtual.enabled;
  if (n.loop) {
    if (o && !d && n.loopPreventsSliding) return !1;
    if (
      (r.loopFix({ direction: "next" }),
      (r._clientLeft = r.wrapperEl.clientLeft),
      r.activeIndex === r.slides.length - 1 && n.cssMode)
    )
      return (
        requestAnimationFrame(() => {
          r.slideTo(r.activeIndex + a, t, e, i);
        }),
        !0
      );
  }
  return n.rewind && r.isEnd
    ? r.slideTo(0, t, e, i)
    : r.slideTo(r.activeIndex + a, t, e, i);
}
function rr(t, e = !0, i) {
  const r = this,
    {
      params: s,
      snapGrid: n,
      slidesGrid: o,
      rtlTranslate: c,
      enabled: a,
      animating: d,
    } = r;
  if (!a || r.destroyed) return r;
  typeof t > "u" && (t = r.params.speed);
  const m = r.virtual && s.virtual.enabled;
  if (s.loop) {
    if (d && !m && s.loopPreventsSliding) return !1;
    (r.loopFix({ direction: "prev" }),
      (r._clientLeft = r.wrapperEl.clientLeft));
  }
  const f = c ? r.translate : -r.translate;
  function g(y) {
    return y < 0 ? -Math.floor(Math.abs(y)) : Math.floor(y);
  }
  const p = g(f),
    w = n.map((y) => g(y)),
    S = s.freeMode && s.freeMode.enabled;
  let L = n[w.indexOf(p) - 1];
  if (typeof L > "u" && (s.cssMode || S)) {
    let y;
    (n.forEach((E, O) => {
      p >= E && (y = O);
    }),
      typeof y < "u" && (L = S ? n[y] : n[y > 0 ? y - 1 : y]));
  }
  let I = 0;
  if (
    (typeof L < "u" &&
      ((I = o.indexOf(L)),
      I < 0 && (I = r.activeIndex - 1),
      s.slidesPerView === "auto" &&
        s.slidesPerGroup === 1 &&
        s.slidesPerGroupAuto &&
        ((I = I - r.slidesPerViewDynamic("previous", !0) + 1),
        (I = Math.max(I, 0)))),
    s.rewind && r.isBeginning)
  ) {
    const y =
      r.params.virtual && r.params.virtual.enabled && r.virtual
        ? r.virtual.slides.length - 1
        : r.slides.length - 1;
    return r.slideTo(y, t, e, i);
  } else if (s.loop && r.activeIndex === 0 && s.cssMode)
    return (
      requestAnimationFrame(() => {
        r.slideTo(I, t, e, i);
      }),
      !0
    );
  return r.slideTo(I, t, e, i);
}
function sr(t, e = !0, i) {
  const r = this;
  if (!r.destroyed)
    return (
      typeof t > "u" && (t = r.params.speed),
      r.slideTo(r.activeIndex, t, e, i)
    );
}
function nr(t, e = !0, i, r = 0.5) {
  const s = this;
  if (s.destroyed) return;
  typeof t > "u" && (t = s.params.speed);
  let n = s.activeIndex;
  const o = Math.min(s.params.slidesPerGroupSkip, n),
    c = o + Math.floor((n - o) / s.params.slidesPerGroup),
    a = s.rtlTranslate ? s.translate : -s.translate;
  if (a >= s.snapGrid[c]) {
    const d = s.snapGrid[c],
      m = s.snapGrid[c + 1];
    a - d > (m - d) * r && (n += s.params.slidesPerGroup);
  } else {
    const d = s.snapGrid[c - 1],
      m = s.snapGrid[c];
    a - d <= (m - d) * r && (n -= s.params.slidesPerGroup);
  }
  return (
    (n = Math.max(n, 0)),
    (n = Math.min(n, s.slidesGrid.length - 1)),
    s.slideTo(n, t, e, i)
  );
}
function ar() {
  const t = this;
  if (t.destroyed) return;
  const { params: e, slidesEl: i } = t,
    r = e.slidesPerView === "auto" ? t.slidesPerViewDynamic() : e.slidesPerView;
  let s = t.getSlideIndexWhenGrid(t.clickedIndex),
    n;
  const o = t.isElement ? "swiper-slide" : `.${e.slideClass}`,
    c = t.grid && t.params.grid && t.params.grid.rows > 1;
  if (e.loop) {
    if (t.animating) return;
    ((n = parseInt(t.clickedSlide.getAttribute("data-swiper-slide-index"), 10)),
      e.centeredSlides
        ? t.slideToLoop(n)
        : s >
            (c
              ? (t.slides.length - r) / 2 - (t.params.grid.rows - 1)
              : t.slides.length - r)
          ? (t.loopFix(),
            (s = t.getSlideIndex(
              le(i, `${o}[data-swiper-slide-index="${n}"]`)[0],
            )),
            Bt(() => {
              t.slideTo(s);
            }))
          : t.slideTo(s));
  } else t.slideTo(s);
}
var or = {
  slideTo: er,
  slideToLoop: tr,
  slideNext: ir,
  slidePrev: rr,
  slideReset: sr,
  slideToClosest: nr,
  slideToClickedSlide: ar,
};
function lr(t, e) {
  const i = this,
    { params: r, slidesEl: s } = i;
  if (!r.loop || (i.virtual && i.params.virtual.enabled)) return;
  const n = () => {
      le(s, `.${r.slideClass}, swiper-slide`).forEach((w, S) => {
        w.setAttribute("data-swiper-slide-index", S);
      });
    },
    o = () => {
      const p = le(s, `.${r.slideBlankClass}`);
      (p.forEach((w) => {
        w.remove();
      }),
        p.length > 0 && (i.recalcSlides(), i.updateSlides()));
    },
    c = i.grid && r.grid && r.grid.rows > 1;
  r.loopAddBlankSlides && (r.slidesPerGroup > 1 || c) && o();
  const a = r.slidesPerGroup * (c ? r.grid.rows : 1),
    d = i.slides.length % a !== 0,
    m = c && i.slides.length % r.grid.rows !== 0,
    f = (p) => {
      for (let w = 0; w < p; w += 1) {
        const S = i.isElement
          ? Je("swiper-slide", [r.slideBlankClass])
          : Je("div", [r.slideClass, r.slideBlankClass]);
        i.slidesEl.append(S);
      }
    };
  if (d) {
    if (r.loopAddBlankSlides) {
      const p = a - (i.slides.length % a);
      (f(p), i.recalcSlides(), i.updateSlides());
    } else
      Ie(
        "Swiper Loop Warning: The number of slides is not even to slidesPerGroup, loop mode may not function properly. You need to add more slides (or make duplicates, or empty slides)",
      );
    n();
  } else if (m) {
    if (r.loopAddBlankSlides) {
      const p = r.grid.rows - (i.slides.length % r.grid.rows);
      (f(p), i.recalcSlides(), i.updateSlides());
    } else
      Ie(
        "Swiper Loop Warning: The number of slides is not even to grid.rows, loop mode may not function properly. You need to add more slides (or make duplicates, or empty slides)",
      );
    n();
  } else n();
  const g = r.centeredSlides || !!r.slidesOffsetBefore || !!r.slidesOffsetAfter;
  i.loopFix({ slideRealIndex: t, direction: g ? void 0 : "next", initial: e });
}
function dr({
  slideRealIndex: t,
  slideTo: e = !0,
  direction: i,
  setTranslate: r,
  activeSlideIndex: s,
  initial: n,
  byController: o,
  byMousewheel: c,
} = {}) {
  const a = this;
  if (!a.params.loop) return;
  a.emit("beforeLoopFix");
  const {
      slides: d,
      allowSlidePrev: m,
      allowSlideNext: f,
      slidesEl: g,
      params: p,
    } = a,
    {
      centeredSlides: w,
      slidesOffsetBefore: S,
      slidesOffsetAfter: L,
      initialSlide: I,
    } = p,
    y = w || !!S || !!L;
  if (
    ((a.allowSlidePrev = !0),
    (a.allowSlideNext = !0),
    a.virtual && p.virtual.enabled)
  ) {
    (e &&
      (!y && a.snapIndex === 0
        ? a.slideTo(a.virtual.slides.length, 0, !1, !0)
        : y && a.snapIndex < p.slidesPerView
          ? a.slideTo(a.virtual.slides.length + a.snapIndex, 0, !1, !0)
          : a.snapIndex === a.snapGrid.length - 1 &&
            a.slideTo(a.virtual.slidesBefore, 0, !1, !0)),
      (a.allowSlidePrev = m),
      (a.allowSlideNext = f),
      a.emit("loopFix"));
    return;
  }
  let E = p.slidesPerView;
  E === "auto"
    ? (E = a.slidesPerViewDynamic())
    : ((E = Math.ceil(parseFloat(p.slidesPerView, 10))),
      y && E % 2 === 0 && (E = E + 1));
  const O = p.slidesPerGroupAuto ? E : p.slidesPerGroup;
  let P = y ? Math.max(O, Math.ceil(E / 2)) : O;
  (P % O !== 0 && (P += O - (P % O)),
    (P += p.loopAdditionalSlides),
    (a.loopedSlides = P));
  const D = a.grid && p.grid && p.grid.rows > 1;
  d.length < E + P || (a.params.effect === "cards" && d.length < E + P * 2)
    ? Ie(
        "Swiper Loop Warning: The number of slides is not enough for loop mode, it will be disabled or not function properly. You need to add more slides (or make duplicates) or lower the values of slidesPerView and slidesPerGroup parameters",
      )
    : D &&
      p.grid.fill === "row" &&
      Ie(
        "Swiper Loop Warning: Loop mode is not compatible with grid.fill = `row`",
      );
  const z = [],
    C = [],
    $ = D ? Math.ceil(d.length / p.grid.rows) : d.length,
    A = n && $ - I < E && !y;
  let M = A ? I : a.activeIndex;
  typeof s > "u"
    ? (s = a.getSlideIndex(
        d.find((_) => _.classList.contains(p.slideActiveClass)),
      ))
    : (M = s);
  const V = i === "next" || !i,
    X = i === "prev" || !i;
  let ee = 0,
    te = 0;
  const oe = (D ? d[s].column : s) + (y && typeof r > "u" ? -E / 2 + 0.5 : 0);
  if (oe < P) {
    ee = Math.max(P - oe, O);
    for (let _ = 0; _ < P - oe; _ += 1) {
      const j = _ - Math.floor(_ / $) * $;
      if (D) {
        const Y = $ - j - 1;
        for (let ne = d.length - 1; ne >= 0; ne -= 1)
          d[ne].column === Y && z.push(ne);
      } else z.push($ - j - 1);
    }
  } else if (oe + E > $ - P) {
    ((te = Math.max(oe - ($ - P * 2), O)),
      A && (te = Math.max(te, E - $ + I + 1)));
    for (let _ = 0; _ < te; _ += 1) {
      const j = _ - Math.floor(_ / $) * $;
      D
        ? d.forEach((Y, ne) => {
            Y.column === j && C.push(ne);
          })
        : C.push(j);
    }
  }
  if (
    ((a.__preventObserver__ = !0),
    requestAnimationFrame(() => {
      a.__preventObserver__ = !1;
    }),
    a.params.effect === "cards" &&
      d.length < E + P * 2 &&
      (C.includes(s) && C.splice(C.indexOf(s), 1),
      z.includes(s) && z.splice(z.indexOf(s), 1)),
    X &&
      z.forEach((_) => {
        ((d[_].swiperLoopMoveDOM = !0),
          g.prepend(d[_]),
          (d[_].swiperLoopMoveDOM = !1));
      }),
    V &&
      C.forEach((_) => {
        ((d[_].swiperLoopMoveDOM = !0),
          g.append(d[_]),
          (d[_].swiperLoopMoveDOM = !1));
      }),
    a.recalcSlides(),
    p.slidesPerView === "auto"
      ? a.updateSlides()
      : D &&
        ((z.length > 0 && X) || (C.length > 0 && V)) &&
        a.slides.forEach((_, j) => {
          a.grid.updateSlide(j, _, a.slides);
        }),
    p.watchSlidesProgress && a.updateSlidesOffset(),
    e)
  ) {
    if (z.length > 0 && X) {
      if (typeof t > "u") {
        const _ = a.slidesGrid[M],
          Y = a.slidesGrid[M + ee] - _;
        c
          ? a.setTranslate(a.translate - Y)
          : (a.slideTo(M + Math.ceil(ee), 0, !1, !0),
            r &&
              ((a.touchEventsData.startTranslate =
                a.touchEventsData.startTranslate - Y),
              (a.touchEventsData.currentTranslate =
                a.touchEventsData.currentTranslate - Y)));
      } else if (r) {
        const _ = D ? z.length / p.grid.rows : z.length;
        (a.slideTo(a.activeIndex + _, 0, !1, !0),
          (a.touchEventsData.currentTranslate = a.translate));
      }
    } else if (C.length > 0 && V)
      if (typeof t > "u") {
        const _ = a.slidesGrid[M],
          Y = a.slidesGrid[M - te] - _;
        c
          ? a.setTranslate(a.translate - Y)
          : (a.slideTo(M - te, 0, !1, !0),
            r &&
              ((a.touchEventsData.startTranslate =
                a.touchEventsData.startTranslate - Y),
              (a.touchEventsData.currentTranslate =
                a.touchEventsData.currentTranslate - Y)));
      } else {
        const _ = D ? C.length / p.grid.rows : C.length;
        a.slideTo(a.activeIndex - _, 0, !1, !0);
      }
  }
  if (
    ((a.allowSlidePrev = m),
    (a.allowSlideNext = f),
    a.controller && a.controller.control && !o)
  ) {
    const _ = {
      slideRealIndex: t,
      direction: i,
      setTranslate: r,
      activeSlideIndex: s,
      byController: !0,
    };
    Array.isArray(a.controller.control)
      ? a.controller.control.forEach((j) => {
          !j.destroyed &&
            j.params.loop &&
            j.loopFix({
              ..._,
              slideTo: j.params.slidesPerView === p.slidesPerView ? e : !1,
            });
        })
      : a.controller.control instanceof a.constructor &&
        a.controller.control.params.loop &&
        a.controller.control.loopFix({
          ..._,
          slideTo:
            a.controller.control.params.slidesPerView === p.slidesPerView
              ? e
              : !1,
        });
  }
  a.emit("loopFix");
}
function cr() {
  const t = this,
    { params: e, slidesEl: i } = t;
  if (!e.loop || !i || (t.virtual && t.params.virtual.enabled)) return;
  t.recalcSlides();
  const r = [];
  (t.slides.forEach((s) => {
    const n =
      typeof s.swiperSlideIndex > "u"
        ? s.getAttribute("data-swiper-slide-index") * 1
        : s.swiperSlideIndex;
    r[n] = s;
  }),
    t.slides.forEach((s) => {
      s.removeAttribute("data-swiper-slide-index");
    }),
    r.forEach((s) => {
      i.append(s);
    }),
    t.recalcSlides(),
    t.slideTo(t.realIndex, 0));
}
var ur = { loopCreate: lr, loopFix: dr, loopDestroy: cr };
function fr(t) {
  const e = this;
  if (
    !e.params.simulateTouch ||
    (e.params.watchOverflow && e.isLocked) ||
    e.params.cssMode
  )
    return;
  const i = e.params.touchEventsTarget === "container" ? e.el : e.wrapperEl;
  (e.isElement && (e.__preventObserver__ = !0),
    (i.style.cursor = "move"),
    (i.style.cursor = t ? "grabbing" : "grab"),
    e.isElement &&
      requestAnimationFrame(() => {
        e.__preventObserver__ = !1;
      }));
}
function pr() {
  const t = this;
  (t.params.watchOverflow && t.isLocked) ||
    t.params.cssMode ||
    (t.isElement && (t.__preventObserver__ = !0),
    (t[
      t.params.touchEventsTarget === "container" ? "el" : "wrapperEl"
    ].style.cursor = ""),
    t.isElement &&
      requestAnimationFrame(() => {
        t.__preventObserver__ = !1;
      }));
}
var hr = { setGrabCursor: fr, unsetGrabCursor: pr };
function mr(t, e = this) {
  function i(r) {
    if (!r || r === me() || r === Z()) return null;
    r.assignedSlot && (r = r.assignedSlot);
    const s = r.closest(t);
    return !s && !r.getRootNode ? null : s || i(r.getRootNode().host);
  }
  return i(e);
}
function xt(t, e, i) {
  const r = Z(),
    { params: s } = t,
    n = s.edgeSwipeDetection,
    o = s.edgeSwipeThreshold;
  return n && (i <= o || i >= r.innerWidth - o)
    ? n === "prevent"
      ? (e.preventDefault(), !0)
      : !1
    : !0;
}
function gr(t) {
  const e = this,
    i = me();
  let r = t;
  r.originalEvent && (r = r.originalEvent);
  const s = e.touchEventsData;
  if (r.type === "pointerdown") {
    if (s.pointerId !== null && s.pointerId !== r.pointerId) return;
    s.pointerId = r.pointerId;
  } else
    r.type === "touchstart" &&
      r.targetTouches.length === 1 &&
      (s.touchId = r.targetTouches[0].identifier);
  if (r.type === "touchstart") {
    xt(e, r, r.targetTouches[0].pageX);
    return;
  }
  const { params: n, touches: o, enabled: c } = e;
  if (
    !c ||
    (!n.simulateTouch && r.pointerType === "mouse") ||
    (e.animating && n.preventInteractionOnTransition)
  )
    return;
  !e.animating && n.cssMode && n.loop && e.loopFix();
  let a = r.target;
  if (
    (n.touchEventsTarget === "wrapper" && !Ti(a, e.wrapperEl)) ||
    ("which" in r && r.which === 3) ||
    ("button" in r && r.button > 0) ||
    (s.isTouched && s.isMoved)
  )
    return;
  const d = !!n.noSwipingClass && n.noSwipingClass !== "",
    m = r.composedPath ? r.composedPath() : r.path;
  d && r.target && r.target.shadowRoot && m && (a = m[0]);
  const f = n.noSwipingSelector ? n.noSwipingSelector : `.${n.noSwipingClass}`,
    g = !!(r.target && r.target.shadowRoot);
  if (n.noSwiping && (g ? mr(f, a) : a.closest(f))) {
    e.allowClick = !0;
    return;
  }
  if (n.swipeHandler && !a.closest(n.swipeHandler)) return;
  ((o.currentX = r.pageX), (o.currentY = r.pageY));
  const p = o.currentX,
    w = o.currentY;
  if (!xt(e, r, p)) return;
  (Object.assign(s, {
    isTouched: !0,
    isMoved: !1,
    allowTouchCallbacks: !0,
    isScrolling: void 0,
    startMoving: void 0,
  }),
    (o.startX = p),
    (o.startY = w),
    (s.touchStartTime = ke()),
    (e.allowClick = !0),
    e.updateSize(),
    (e.swipeDirection = void 0),
    n.threshold > 0 && (s.allowThresholdMove = !1));
  let S = !0;
  (a.matches(s.focusableElements) &&
    ((S = !1), a.nodeName === "SELECT" && (s.isTouched = !1)),
    i.activeElement &&
      i.activeElement.matches(s.focusableElements) &&
      i.activeElement !== a &&
      (r.pointerType === "mouse" ||
        (r.pointerType !== "mouse" && !a.matches(s.focusableElements))) &&
      i.activeElement.blur());
  const L = S && e.allowTouchMove && n.touchStartPreventDefault;
  ((n.touchStartForcePreventDefault || L) &&
    !a.isContentEditable &&
    r.preventDefault(),
    n.freeMode &&
      n.freeMode.enabled &&
      e.freeMode &&
      e.animating &&
      !n.cssMode &&
      e.freeMode.onTouchStart(),
    e.emit("touchStart", r));
}
function vr(t) {
  const e = me(),
    i = this,
    r = i.touchEventsData,
    { params: s, touches: n, rtlTranslate: o, enabled: c } = i;
  if (!c || (!s.simulateTouch && t.pointerType === "mouse")) return;
  let a = t;
  if (
    (a.originalEvent && (a = a.originalEvent),
    a.type === "pointermove" &&
      (r.touchId !== null || a.pointerId !== r.pointerId))
  )
    return;
  let d;
  if (a.type === "touchmove") {
    if (
      ((d = [...a.changedTouches].find((P) => P.identifier === r.touchId)),
      !d || d.identifier !== r.touchId)
    )
      return;
  } else d = a;
  if (!r.isTouched) {
    r.startMoving && r.isScrolling && i.emit("touchMoveOpposite", a);
    return;
  }
  const m = d.pageX,
    f = d.pageY;
  if (a.preventedByNestedSwiper) {
    ((n.startX = m), (n.startY = f));
    return;
  }
  if (!i.allowTouchMove) {
    (a.target.matches(r.focusableElements) || (i.allowClick = !1),
      r.isTouched &&
        (Object.assign(n, { startX: m, startY: f, currentX: m, currentY: f }),
        (r.touchStartTime = ke())));
    return;
  }
  if (s.touchReleaseOnEdges && !s.loop)
    if (i.isVertical()) {
      if (
        (f < n.startY && i.translate <= i.maxTranslate()) ||
        (f > n.startY && i.translate >= i.minTranslate())
      ) {
        ((r.isTouched = !1), (r.isMoved = !1));
        return;
      }
    } else {
      if (
        o &&
        ((m > n.startX && -i.translate <= i.maxTranslate()) ||
          (m < n.startX && -i.translate >= i.minTranslate()))
      )
        return;
      if (
        !o &&
        ((m < n.startX && i.translate <= i.maxTranslate()) ||
          (m > n.startX && i.translate >= i.minTranslate()))
      )
        return;
    }
  if (
    (e.activeElement &&
      e.activeElement.matches(r.focusableElements) &&
      e.activeElement !== a.target &&
      a.pointerType !== "mouse" &&
      e.activeElement.blur(),
    e.activeElement &&
      a.target === e.activeElement &&
      a.target.matches(r.focusableElements))
  ) {
    ((r.isMoved = !0), (i.allowClick = !1));
    return;
  }
  (r.allowTouchCallbacks && i.emit("touchMove", a),
    (n.previousX = n.currentX),
    (n.previousY = n.currentY),
    (n.currentX = m),
    (n.currentY = f));
  const g = n.currentX - n.startX,
    p = n.currentY - n.startY;
  if (i.params.threshold && Math.sqrt(g ** 2 + p ** 2) < i.params.threshold)
    return;
  if (typeof r.isScrolling > "u") {
    let P;
    (i.isHorizontal() && n.currentY === n.startY) ||
    (i.isVertical() && n.currentX === n.startX)
      ? (r.isScrolling = !1)
      : g * g + p * p >= 25 &&
        ((P = (Math.atan2(Math.abs(p), Math.abs(g)) * 180) / Math.PI),
        (r.isScrolling = i.isHorizontal()
          ? P > s.touchAngle
          : 90 - P > s.touchAngle));
  }
  if (
    (r.isScrolling && i.emit("touchMoveOpposite", a),
    typeof r.startMoving > "u" &&
      (n.currentX !== n.startX || n.currentY !== n.startY) &&
      (r.startMoving = !0),
    r.isScrolling ||
      (a.type === "touchmove" && r.preventTouchMoveFromPointerMove))
  ) {
    r.isTouched = !1;
    return;
  }
  if (!r.startMoving) return;
  ((i.allowClick = !1),
    !s.cssMode && a.cancelable && a.preventDefault(),
    s.touchMoveStopPropagation && !s.nested && a.stopPropagation());
  let w = i.isHorizontal() ? g : p,
    S = i.isHorizontal() ? n.currentX - n.previousX : n.currentY - n.previousY;
  (s.oneWayMovement &&
    ((w = Math.abs(w) * (o ? 1 : -1)), (S = Math.abs(S) * (o ? 1 : -1))),
    (n.diff = w),
    (w *= s.touchRatio),
    o && ((w = -w), (S = -S)));
  const L = i.touchesDirection;
  ((i.swipeDirection = w > 0 ? "prev" : "next"),
    (i.touchesDirection = S > 0 ? "prev" : "next"));
  const I = i.params.loop && !s.cssMode,
    y =
      (i.touchesDirection === "next" && i.allowSlideNext) ||
      (i.touchesDirection === "prev" && i.allowSlidePrev);
  if (!r.isMoved) {
    if (
      (I && y && i.loopFix({ direction: i.swipeDirection }),
      (r.startTranslate = i.getTranslate()),
      i.setTransition(0),
      i.animating)
    ) {
      const P = new window.CustomEvent("transitionend", {
        bubbles: !0,
        cancelable: !0,
        detail: { bySwiperTouchMove: !0 },
      });
      i.wrapperEl.dispatchEvent(P);
    }
    ((r.allowMomentumBounce = !1),
      s.grabCursor &&
        (i.allowSlideNext === !0 || i.allowSlidePrev === !0) &&
        i.setGrabCursor(!0),
      i.emit("sliderFirstMove", a));
  }
  if (
    (new Date().getTime(),
    s._loopSwapReset !== !1 &&
      r.isMoved &&
      r.allowThresholdMove &&
      L !== i.touchesDirection &&
      I &&
      y &&
      Math.abs(w) >= 1)
  ) {
    (Object.assign(n, {
      startX: m,
      startY: f,
      currentX: m,
      currentY: f,
      startTranslate: r.currentTranslate,
    }),
      (r.loopSwapReset = !0),
      (r.startTranslate = r.currentTranslate));
    return;
  }
  (i.emit("sliderMove", a),
    (r.isMoved = !0),
    (r.currentTranslate = w + r.startTranslate));
  let E = !0,
    O = s.resistanceRatio;
  if (
    (s.touchReleaseOnEdges && (O = 0),
    w > 0
      ? (I &&
          y &&
          r.allowThresholdMove &&
          r.currentTranslate >
            (s.centeredSlides
              ? i.minTranslate() -
                i.slidesSizesGrid[i.activeIndex + 1] -
                (s.slidesPerView !== "auto" &&
                i.slides.length - s.slidesPerView >= 2
                  ? i.slidesSizesGrid[i.activeIndex + 1] + i.params.spaceBetween
                  : 0) -
                i.params.spaceBetween
              : i.minTranslate()) &&
          i.loopFix({
            direction: "prev",
            setTranslate: !0,
            activeSlideIndex: 0,
          }),
        r.currentTranslate > i.minTranslate() &&
          ((E = !1),
          s.resistance &&
            (r.currentTranslate =
              i.minTranslate() -
              1 +
              (-i.minTranslate() + r.startTranslate + w) ** O)))
      : w < 0 &&
        (I &&
          y &&
          r.allowThresholdMove &&
          r.currentTranslate <
            (s.centeredSlides
              ? i.maxTranslate() +
                i.slidesSizesGrid[i.slidesSizesGrid.length - 1] +
                i.params.spaceBetween +
                (s.slidesPerView !== "auto" &&
                i.slides.length - s.slidesPerView >= 2
                  ? i.slidesSizesGrid[i.slidesSizesGrid.length - 1] +
                    i.params.spaceBetween
                  : 0)
              : i.maxTranslate()) &&
          i.loopFix({
            direction: "next",
            setTranslate: !0,
            activeSlideIndex:
              i.slides.length -
              (s.slidesPerView === "auto"
                ? i.slidesPerViewDynamic()
                : Math.ceil(parseFloat(s.slidesPerView, 10))),
          }),
        r.currentTranslate < i.maxTranslate() &&
          ((E = !1),
          s.resistance &&
            (r.currentTranslate =
              i.maxTranslate() +
              1 -
              (i.maxTranslate() - r.startTranslate - w) ** O))),
    E && (a.preventedByNestedSwiper = !0),
    !i.allowSlideNext &&
      i.swipeDirection === "next" &&
      r.currentTranslate < r.startTranslate &&
      (r.currentTranslate = r.startTranslate),
    !i.allowSlidePrev &&
      i.swipeDirection === "prev" &&
      r.currentTranslate > r.startTranslate &&
      (r.currentTranslate = r.startTranslate),
    !i.allowSlidePrev &&
      !i.allowSlideNext &&
      (r.currentTranslate = r.startTranslate),
    s.threshold > 0)
  )
    if (Math.abs(w) > s.threshold || r.allowThresholdMove) {
      if (!r.allowThresholdMove) {
        ((r.allowThresholdMove = !0),
          (n.startX = n.currentX),
          (n.startY = n.currentY),
          (r.currentTranslate = r.startTranslate),
          (n.diff = i.isHorizontal()
            ? n.currentX - n.startX
            : n.currentY - n.startY));
        return;
      }
    } else {
      r.currentTranslate = r.startTranslate;
      return;
    }
  !s.followFinger ||
    s.cssMode ||
    (((s.freeMode && s.freeMode.enabled && i.freeMode) ||
      s.watchSlidesProgress) &&
      (i.updateActiveIndex(), i.updateSlidesClasses()),
    s.freeMode && s.freeMode.enabled && i.freeMode && i.freeMode.onTouchMove(),
    i.updateProgress(r.currentTranslate),
    i.setTranslate(r.currentTranslate));
}
function Sr(t) {
  const e = this,
    i = e.touchEventsData;
  let r = t;
  r.originalEvent && (r = r.originalEvent);
  let s;
  if (r.type === "touchend" || r.type === "touchcancel") {
    if (
      ((s = [...r.changedTouches].find((P) => P.identifier === i.touchId)),
      !s || s.identifier !== i.touchId)
    )
      return;
  } else {
    if (i.touchId !== null || r.pointerId !== i.pointerId) return;
    s = r;
  }
  if (
    ["pointercancel", "pointerout", "pointerleave", "contextmenu"].includes(
      r.type,
    ) &&
    !(
      ["pointercancel", "contextmenu"].includes(r.type) &&
      (e.browser.isSafari || e.browser.isWebView)
    )
  )
    return;
  ((i.pointerId = null), (i.touchId = null));
  const {
    params: o,
    touches: c,
    rtlTranslate: a,
    slidesGrid: d,
    enabled: m,
  } = e;
  if (!m || (!o.simulateTouch && r.pointerType === "mouse")) return;
  if (
    (i.allowTouchCallbacks && e.emit("touchEnd", r),
    (i.allowTouchCallbacks = !1),
    !i.isTouched)
  ) {
    (i.isMoved && o.grabCursor && e.setGrabCursor(!1),
      (i.isMoved = !1),
      (i.startMoving = !1));
    return;
  }
  o.grabCursor &&
    i.isMoved &&
    i.isTouched &&
    (e.allowSlideNext === !0 || e.allowSlidePrev === !0) &&
    e.setGrabCursor(!1);
  const f = ke(),
    g = f - i.touchStartTime;
  if (e.allowClick) {
    const P = r.path || (r.composedPath && r.composedPath());
    (e.updateClickedSlide((P && P[0]) || r.target, P),
      e.emit("tap click", r),
      g < 300 &&
        f - i.lastClickTime < 300 &&
        e.emit("doubleTap doubleClick", r));
  }
  if (
    ((i.lastClickTime = ke()),
    Bt(() => {
      e.destroyed || (e.allowClick = !0);
    }),
    !i.isTouched ||
      !i.isMoved ||
      !e.swipeDirection ||
      (c.diff === 0 && !i.loopSwapReset) ||
      (i.currentTranslate === i.startTranslate && !i.loopSwapReset))
  ) {
    ((i.isTouched = !1), (i.isMoved = !1), (i.startMoving = !1));
    return;
  }
  ((i.isTouched = !1), (i.isMoved = !1), (i.startMoving = !1));
  let p;
  if (
    (o.followFinger
      ? (p = a ? e.translate : -e.translate)
      : (p = -i.currentTranslate),
    o.cssMode)
  )
    return;
  if (o.freeMode && o.freeMode.enabled) {
    e.freeMode.onTouchEnd({ currentPos: p });
    return;
  }
  const w = p >= -e.maxTranslate() && !e.params.loop;
  let S = 0,
    L = e.slidesSizesGrid[0];
  for (
    let P = 0;
    P < d.length;
    P += P < o.slidesPerGroupSkip ? 1 : o.slidesPerGroup
  ) {
    const D = P < o.slidesPerGroupSkip - 1 ? 1 : o.slidesPerGroup;
    typeof d[P + D] < "u"
      ? (w || (p >= d[P] && p < d[P + D])) && ((S = P), (L = d[P + D] - d[P]))
      : (w || p >= d[P]) && ((S = P), (L = d[d.length - 1] - d[d.length - 2]));
  }
  let I = null,
    y = null;
  o.rewind &&
    (e.isBeginning
      ? (y =
          o.virtual && o.virtual.enabled && e.virtual
            ? e.virtual.slides.length - 1
            : e.slides.length - 1)
      : e.isEnd && (I = 0));
  const E = (p - d[S]) / L,
    O = S < o.slidesPerGroupSkip - 1 ? 1 : o.slidesPerGroup;
  if (g > o.longSwipesMs) {
    if (!o.longSwipes) {
      e.slideTo(e.activeIndex);
      return;
    }
    (e.swipeDirection === "next" &&
      (E >= o.longSwipesRatio
        ? e.slideTo(o.rewind && e.isEnd ? I : S + O)
        : e.slideTo(S)),
      e.swipeDirection === "prev" &&
        (E > 1 - o.longSwipesRatio
          ? e.slideTo(S + O)
          : y !== null && E < 0 && Math.abs(E) > o.longSwipesRatio
            ? e.slideTo(y)
            : e.slideTo(S)));
  } else {
    if (!o.shortSwipes) {
      e.slideTo(e.activeIndex);
      return;
    }
    e.navigation &&
    (r.target === e.navigation.nextEl || r.target === e.navigation.prevEl)
      ? r.target === e.navigation.nextEl
        ? e.slideTo(S + O)
        : e.slideTo(S)
      : (e.swipeDirection === "next" && e.slideTo(I !== null ? I : S + O),
        e.swipeDirection === "prev" && e.slideTo(y !== null ? y : S));
  }
}
function yt() {
  const t = this,
    { params: e, el: i } = t;
  if (i && i.offsetWidth === 0) return;
  e.breakpoints && t.setBreakpoint();
  const { allowSlideNext: r, allowSlidePrev: s, snapGrid: n } = t,
    o = t.virtual && t.params.virtual.enabled;
  ((t.allowSlideNext = !0),
    (t.allowSlidePrev = !0),
    t.updateSize(),
    t.updateSlides(),
    t.updateSlidesClasses());
  const c = o && e.loop;
  ((e.slidesPerView === "auto" || e.slidesPerView > 1) &&
  t.isEnd &&
  !t.isBeginning &&
  !t.params.centeredSlides &&
  !c
    ? t.slideTo(t.slides.length - 1, 0, !1, !0)
    : t.params.loop && !o
      ? t.slideToLoop(t.realIndex, 0, !1, !0)
      : t.slideTo(t.activeIndex, 0, !1, !0),
    t.autoplay &&
      t.autoplay.running &&
      t.autoplay.paused &&
      (clearTimeout(t.autoplay.resizeTimeout),
      (t.autoplay.resizeTimeout = setTimeout(() => {
        t.autoplay &&
          t.autoplay.running &&
          t.autoplay.paused &&
          t.autoplay.resume();
      }, 500))),
    (t.allowSlidePrev = s),
    (t.allowSlideNext = r),
    t.params.watchOverflow && n !== t.snapGrid && t.checkOverflow());
}
function wr(t) {
  const e = this;
  e.enabled &&
    (e.allowClick ||
      (e.params.preventClicks && t.preventDefault(),
      e.params.preventClicksPropagation &&
        e.animating &&
        (t.stopPropagation(), t.stopImmediatePropagation())));
}
function br() {
  const t = this,
    { wrapperEl: e, rtlTranslate: i, enabled: r } = t;
  if (!r) return;
  ((t.previousTranslate = t.translate),
    t.isHorizontal()
      ? (t.translate = -e.scrollLeft)
      : (t.translate = -e.scrollTop),
    t.translate === 0 && (t.translate = 0),
    t.updateActiveIndex(),
    t.updateSlidesClasses());
  let s;
  const n = t.maxTranslate() - t.minTranslate();
  (n === 0 ? (s = 0) : (s = (t.translate - t.minTranslate()) / n),
    s !== t.progress && t.updateProgress(i ? -t.translate : t.translate),
    t.emit("setTranslate", t.translate, !1));
}
function xr(t) {
  const e = this;
  (Le(e, t.target),
    !(
      e.params.cssMode ||
      (e.params.slidesPerView !== "auto" && !e.params.autoHeight)
    ) && e.update());
}
function yr() {
  const t = this;
  t.documentTouchHandlerProceeded ||
    ((t.documentTouchHandlerProceeded = !0),
    t.params.touchReleaseOnEdges && (t.el.style.touchAction = "auto"));
}
const qt = (t, e) => {
  const i = me(),
    { params: r, el: s, wrapperEl: n, device: o } = t,
    c = !!r.nested,
    a = e === "on" ? "addEventListener" : "removeEventListener",
    d = e;
  !s ||
    typeof s == "string" ||
    (i[a]("touchstart", t.onDocumentTouchStart, { passive: !1, capture: c }),
    s[a]("touchstart", t.onTouchStart, { passive: !1 }),
    s[a]("pointerdown", t.onTouchStart, { passive: !1 }),
    i[a]("touchmove", t.onTouchMove, { passive: !1, capture: c }),
    i[a]("pointermove", t.onTouchMove, { passive: !1, capture: c }),
    i[a]("touchend", t.onTouchEnd, { passive: !0 }),
    i[a]("pointerup", t.onTouchEnd, { passive: !0 }),
    i[a]("pointercancel", t.onTouchEnd, { passive: !0 }),
    i[a]("touchcancel", t.onTouchEnd, { passive: !0 }),
    i[a]("pointerout", t.onTouchEnd, { passive: !0 }),
    i[a]("pointerleave", t.onTouchEnd, { passive: !0 }),
    i[a]("contextmenu", t.onTouchEnd, { passive: !0 }),
    (r.preventClicks || r.preventClicksPropagation) &&
      s[a]("click", t.onClick, !0),
    r.cssMode && n[a]("scroll", t.onScroll),
    r.updateOnWindowResize
      ? t[d](
          o.ios || o.android
            ? "resize orientationchange observerUpdate"
            : "resize observerUpdate",
          yt,
          !0,
        )
      : t[d]("observerUpdate", yt, !0),
    s[a]("load", t.onLoad, { capture: !0 }));
};
function Tr() {
  const t = this,
    { params: e } = t;
  ((t.onTouchStart = gr.bind(t)),
    (t.onTouchMove = vr.bind(t)),
    (t.onTouchEnd = Sr.bind(t)),
    (t.onDocumentTouchStart = yr.bind(t)),
    e.cssMode && (t.onScroll = br.bind(t)),
    (t.onClick = wr.bind(t)),
    (t.onLoad = xr.bind(t)),
    qt(t, "on"));
}
function Er() {
  qt(this, "off");
}
var Cr = { attachEvents: Tr, detachEvents: Er };
const Tt = (t, e) => t.grid && e.grid && e.grid.rows > 1;
function Pr() {
  const t = this,
    { realIndex: e, initialized: i, params: r, el: s } = t,
    n = r.breakpoints;
  if (!n || (n && Object.keys(n).length === 0)) return;
  const o = me(),
    c =
      r.breakpointsBase === "window" || !r.breakpointsBase
        ? r.breakpointsBase
        : "container",
    a =
      ["window", "container"].includes(r.breakpointsBase) || !r.breakpointsBase
        ? t.el
        : o.querySelector(r.breakpointsBase),
    d = t.getBreakpoint(n, c, a);
  if (!d || t.currentBreakpoint === d) return;
  const f = (d in n ? n[d] : void 0) || t.originalParams,
    g = Tt(t, r),
    p = Tt(t, f),
    w = t.params.grabCursor,
    S = f.grabCursor,
    L = r.enabled;
  (g && !p
    ? (s.classList.remove(
        `${r.containerModifierClass}grid`,
        `${r.containerModifierClass}grid-column`,
      ),
      t.emitContainerClasses())
    : !g &&
      p &&
      (s.classList.add(`${r.containerModifierClass}grid`),
      ((f.grid.fill && f.grid.fill === "column") ||
        (!f.grid.fill && r.grid.fill === "column")) &&
        s.classList.add(`${r.containerModifierClass}grid-column`),
      t.emitContainerClasses()),
    w && !S ? t.unsetGrabCursor() : !w && S && t.setGrabCursor(),
    ["navigation", "pagination", "scrollbar"].forEach((D) => {
      if (typeof f[D] > "u") return;
      const z = r[D] && r[D].enabled,
        C = f[D] && f[D].enabled;
      (z && !C && t[D].disable(), !z && C && t[D].enable());
    }));
  const I = f.direction && f.direction !== r.direction,
    y = r.loop && (f.slidesPerView !== r.slidesPerView || I),
    E = r.loop;
  (I && i && t.changeDirection(), ie(t.params, f));
  const O = t.params.enabled,
    P = t.params.loop;
  (Object.assign(t, {
    allowTouchMove: t.params.allowTouchMove,
    allowSlideNext: t.params.allowSlideNext,
    allowSlidePrev: t.params.allowSlidePrev,
  }),
    L && !O ? t.disable() : !L && O && t.enable(),
    (t.currentBreakpoint = d),
    t.emit("_beforeBreakpoint", f),
    i &&
      (y
        ? (t.loopDestroy(), t.loopCreate(e), t.updateSlides())
        : !E && P
          ? (t.loopCreate(e), t.updateSlides())
          : E && !P && t.loopDestroy()),
    t.emit("breakpoint", f));
}
function Mr(t, e = "window", i) {
  if (!t || (e === "container" && !i)) return;
  let r = !1;
  const s = Z(),
    n = e === "window" ? s.innerHeight : i.clientHeight,
    o = Object.keys(t).map((c) => {
      if (typeof c == "string" && c.indexOf("@") === 0) {
        const a = parseFloat(c.substr(1));
        return { value: n * a, point: c };
      }
      return { value: c, point: c };
    });
  o.sort((c, a) => parseInt(c.value, 10) - parseInt(a.value, 10));
  for (let c = 0; c < o.length; c += 1) {
    const { point: a, value: d } = o[c];
    e === "window"
      ? s.matchMedia(`(min-width: ${d}px)`).matches && (r = a)
      : d <= i.clientWidth && (r = a);
  }
  return r || "max";
}
var Lr = { setBreakpoint: Pr, getBreakpoint: Mr };
function Ar(t, e) {
  const i = [];
  return (
    t.forEach((r) => {
      typeof r == "object"
        ? Object.keys(r).forEach((s) => {
            r[s] && i.push(e + s);
          })
        : typeof r == "string" && i.push(e + r);
    }),
    i
  );
}
function kr() {
  const t = this,
    { classNames: e, params: i, rtl: r, el: s, device: n } = t,
    o = Ar(
      [
        "initialized",
        i.direction,
        { "free-mode": t.params.freeMode && i.freeMode.enabled },
        { autoheight: i.autoHeight },
        { rtl: r },
        { grid: i.grid && i.grid.rows > 1 },
        {
          "grid-column": i.grid && i.grid.rows > 1 && i.grid.fill === "column",
        },
        { android: n.android },
        { ios: n.ios },
        { "css-mode": i.cssMode },
        { centered: i.cssMode && i.centeredSlides },
        { "watch-progress": i.watchSlidesProgress },
      ],
      i.containerModifierClass,
    );
  (e.push(...o), s.classList.add(...e), t.emitContainerClasses());
}
function Ir() {
  const t = this,
    { el: e, classNames: i } = t;
  !e ||
    typeof e == "string" ||
    (e.classList.remove(...i), t.emitContainerClasses());
}
var Or = { addClasses: kr, removeClasses: Ir };
function _r() {
  const t = this,
    { isLocked: e, params: i } = t,
    { slidesOffsetBefore: r } = i;
  if (r) {
    const s = t.slides.length - 1,
      n = t.slidesGrid[s] + t.slidesSizesGrid[s] + r * 2;
    t.isLocked = t.size > n;
  } else t.isLocked = t.snapGrid.length === 1;
  (i.allowSlideNext === !0 && (t.allowSlideNext = !t.isLocked),
    i.allowSlidePrev === !0 && (t.allowSlidePrev = !t.isLocked),
    e && e !== t.isLocked && (t.isEnd = !1),
    e !== t.isLocked && t.emit(t.isLocked ? "lock" : "unlock"));
}
var Vr = { checkOverflow: _r },
  Et = {
    init: !0,
    direction: "horizontal",
    oneWayMovement: !1,
    swiperElementNodeName: "SWIPER-CONTAINER",
    touchEventsTarget: "wrapper",
    initialSlide: 0,
    speed: 300,
    cssMode: !1,
    updateOnWindowResize: !0,
    resizeObserver: !0,
    nested: !1,
    createElements: !1,
    eventsPrefix: "swiper",
    enabled: !0,
    focusableElements: "input, select, option, textarea, button, video, label",
    width: null,
    height: null,
    preventInteractionOnTransition: !1,
    userAgent: null,
    url: null,
    edgeSwipeDetection: !1,
    edgeSwipeThreshold: 20,
    autoHeight: !1,
    setWrapperSize: !1,
    virtualTranslate: !1,
    effect: "slide",
    breakpoints: void 0,
    breakpointsBase: "window",
    spaceBetween: 0,
    slidesPerView: 1,
    slidesPerGroup: 1,
    slidesPerGroupSkip: 0,
    slidesPerGroupAuto: !1,
    centeredSlides: !1,
    centeredSlidesBounds: !1,
    slidesOffsetBefore: 0,
    slidesOffsetAfter: 0,
    normalizeSlideIndex: !0,
    centerInsufficientSlides: !1,
    watchOverflow: !0,
    roundLengths: !1,
    touchRatio: 1,
    touchAngle: 45,
    simulateTouch: !0,
    shortSwipes: !0,
    longSwipes: !0,
    longSwipesRatio: 0.5,
    longSwipesMs: 300,
    followFinger: !0,
    allowTouchMove: !0,
    threshold: 5,
    touchMoveStopPropagation: !1,
    touchStartPreventDefault: !0,
    touchStartForcePreventDefault: !1,
    touchReleaseOnEdges: !1,
    uniqueNavElements: !0,
    resistance: !0,
    resistanceRatio: 0.85,
    watchSlidesProgress: !1,
    grabCursor: !1,
    preventClicks: !0,
    preventClicksPropagation: !0,
    slideToClickedSlide: !1,
    loop: !1,
    loopAddBlankSlides: !0,
    loopAdditionalSlides: 0,
    loopPreventsSliding: !0,
    rewind: !1,
    allowSlidePrev: !0,
    allowSlideNext: !0,
    swipeHandler: null,
    noSwiping: !0,
    noSwipingClass: "swiper-no-swiping",
    noSwipingSelector: null,
    passiveListeners: !0,
    maxBackfaceHiddenSlides: 10,
    containerModifierClass: "swiper-",
    slideClass: "swiper-slide",
    slideBlankClass: "swiper-slide-blank",
    slideActiveClass: "swiper-slide-active",
    slideVisibleClass: "swiper-slide-visible",
    slideFullyVisibleClass: "swiper-slide-fully-visible",
    slideNextClass: "swiper-slide-next",
    slidePrevClass: "swiper-slide-prev",
    wrapperClass: "swiper-wrapper",
    lazyPreloaderClass: "swiper-lazy-preloader",
    lazyPreloadPrevNext: 0,
    runCallbacksOnInit: !0,
    _emitClasses: !1,
  };
function zr(t, e) {
  return function (r = {}) {
    const s = Object.keys(r)[0],
      n = r[s];
    if (typeof n != "object" || n === null) {
      ie(e, r);
      return;
    }
    if (
      (t[s] === !0 && (t[s] = { enabled: !0 }),
      s === "navigation" &&
        t[s] &&
        t[s].enabled &&
        !t[s].prevEl &&
        !t[s].nextEl &&
        (t[s].auto = !0),
      ["pagination", "scrollbar"].indexOf(s) >= 0 &&
        t[s] &&
        t[s].enabled &&
        !t[s].el &&
        (t[s].auto = !0),
      !(s in t && "enabled" in n))
    ) {
      ie(e, r);
      return;
    }
    (typeof t[s] == "object" && !("enabled" in t[s]) && (t[s].enabled = !0),
      t[s] || (t[s] = { enabled: !1 }),
      ie(e, r));
  };
}
const Ke = {
    eventsEmitter: Oi,
    update: ji,
    translate: Yi,
    transition: Zi,
    slide: or,
    loop: ur,
    grabCursor: hr,
    events: Cr,
    breakpoints: Lr,
    checkOverflow: Vr,
    classes: Or,
  },
  Qe = {};
class re {
  constructor(...e) {
    let i, r;
    (e.length === 1 &&
    e[0].constructor &&
    Object.prototype.toString.call(e[0]).slice(8, -1) === "Object"
      ? (r = e[0])
      : ([i, r] = e),
      r || (r = {}),
      (r = ie({}, r)),
      i && !r.el && (r.el = i));
    const s = me();
    if (
      r.el &&
      typeof r.el == "string" &&
      s.querySelectorAll(r.el).length > 1
    ) {
      const a = [];
      return (
        s.querySelectorAll(r.el).forEach((d) => {
          const m = ie({}, r, { el: d });
          a.push(new re(m));
        }),
        a
      );
    }
    const n = this;
    ((n.__swiper__ = !0),
      (n.support = Ht()),
      (n.device = Nt({ userAgent: r.userAgent })),
      (n.browser = Rt()),
      (n.eventsListeners = {}),
      (n.eventsAnyListeners = []),
      (n.modules = [...n.__modules__]),
      r.modules && Array.isArray(r.modules) && n.modules.push(...r.modules));
    const o = {};
    n.modules.forEach((a) => {
      a({
        params: r,
        swiper: n,
        extendParams: zr(r, o),
        on: n.on.bind(n),
        once: n.once.bind(n),
        off: n.off.bind(n),
        emit: n.emit.bind(n),
      });
    });
    const c = ie({}, Et, o);
    return (
      (n.params = ie({}, c, Qe, r)),
      (n.originalParams = ie({}, n.params)),
      (n.passedParams = ie({}, r)),
      n.params &&
        n.params.on &&
        Object.keys(n.params.on).forEach((a) => {
          n.on(a, n.params.on[a]);
        }),
      n.params && n.params.onAny && n.onAny(n.params.onAny),
      Object.assign(n, {
        enabled: n.params.enabled,
        el: i,
        classNames: [],
        slides: [],
        slidesGrid: [],
        snapGrid: [],
        slidesSizesGrid: [],
        isHorizontal() {
          return n.params.direction === "horizontal";
        },
        isVertical() {
          return n.params.direction === "vertical";
        },
        activeIndex: 0,
        realIndex: 0,
        isBeginning: !0,
        isEnd: !1,
        translate: 0,
        previousTranslate: 0,
        progress: 0,
        velocity: 0,
        animating: !1,
        cssOverflowAdjustment() {
          return Math.trunc(this.translate / 2 ** 23) * 2 ** 23;
        },
        allowSlideNext: n.params.allowSlideNext,
        allowSlidePrev: n.params.allowSlidePrev,
        touchEventsData: {
          isTouched: void 0,
          isMoved: void 0,
          allowTouchCallbacks: void 0,
          touchStartTime: void 0,
          isScrolling: void 0,
          currentTranslate: void 0,
          startTranslate: void 0,
          allowThresholdMove: void 0,
          focusableElements: n.params.focusableElements,
          lastClickTime: 0,
          clickTimeout: void 0,
          velocities: [],
          allowMomentumBounce: void 0,
          startMoving: void 0,
          pointerId: null,
          touchId: null,
        },
        allowClick: !0,
        allowTouchMove: n.params.allowTouchMove,
        touches: { startX: 0, startY: 0, currentX: 0, currentY: 0, diff: 0 },
        imagesToLoad: [],
        imagesLoaded: 0,
      }),
      n.emit("_swiper"),
      n.params.init && n.init(),
      n
    );
  }
  getDirectionLabel(e) {
    return this.isHorizontal()
      ? e
      : {
          width: "height",
          "margin-top": "margin-left",
          "margin-bottom ": "margin-right",
          "margin-left": "margin-top",
          "margin-right": "margin-bottom",
          "padding-left": "padding-top",
          "padding-right": "padding-bottom",
          marginRight: "marginBottom",
        }[e];
  }
  getSlideIndex(e) {
    const { slidesEl: i, params: r } = this,
      s = le(i, `.${r.slideClass}, swiper-slide`),
      n = St(s[0]);
    return St(e) - n;
  }
  getSlideIndexByData(e) {
    return this.getSlideIndex(
      this.slides.find(
        (i) => i.getAttribute("data-swiper-slide-index") * 1 === e,
      ),
    );
  }
  getSlideIndexWhenGrid(e) {
    return (
      this.grid &&
        this.params.grid &&
        this.params.grid.rows > 1 &&
        (this.params.grid.fill === "column"
          ? (e = Math.floor(e / this.params.grid.rows))
          : this.params.grid.fill === "row" &&
            (e = e % Math.ceil(this.slides.length / this.params.grid.rows))),
      e
    );
  }
  recalcSlides() {
    const e = this,
      { slidesEl: i, params: r } = e;
    e.slides = le(i, `.${r.slideClass}, swiper-slide`);
  }
  enable() {
    const e = this;
    e.enabled ||
      ((e.enabled = !0),
      e.params.grabCursor && e.setGrabCursor(),
      e.emit("enable"));
  }
  disable() {
    const e = this;
    e.enabled &&
      ((e.enabled = !1),
      e.params.grabCursor && e.unsetGrabCursor(),
      e.emit("disable"));
  }
  setProgress(e, i) {
    const r = this;
    e = Math.min(Math.max(e, 0), 1);
    const s = r.minTranslate(),
      o = (r.maxTranslate() - s) * e + s;
    (r.translateTo(o, typeof i > "u" ? 0 : i),
      r.updateActiveIndex(),
      r.updateSlidesClasses());
  }
  emitContainerClasses() {
    const e = this;
    if (!e.params._emitClasses || !e.el) return;
    const i = e.el.className
      .split(" ")
      .filter(
        (r) =>
          r.indexOf("swiper") === 0 ||
          r.indexOf(e.params.containerModifierClass) === 0,
      );
    e.emit("_containerClasses", i.join(" "));
  }
  getSlideClasses(e) {
    const i = this;
    return i.destroyed
      ? ""
      : e.className
          .split(" ")
          .filter(
            (r) =>
              r.indexOf("swiper-slide") === 0 ||
              r.indexOf(i.params.slideClass) === 0,
          )
          .join(" ");
  }
  emitSlidesClasses() {
    const e = this;
    if (!e.params._emitClasses || !e.el) return;
    const i = [];
    (e.slides.forEach((r) => {
      const s = e.getSlideClasses(r);
      (i.push({ slideEl: r, classNames: s }), e.emit("_slideClass", r, s));
    }),
      e.emit("_slideClasses", i));
  }
  slidesPerViewDynamic(e = "current", i = !1) {
    const r = this,
      {
        params: s,
        slides: n,
        slidesGrid: o,
        slidesSizesGrid: c,
        size: a,
        activeIndex: d,
      } = r;
    let m = 1;
    if (typeof s.slidesPerView == "number") return s.slidesPerView;
    if (s.centeredSlides) {
      let f = n[d] ? Math.ceil(n[d].swiperSlideSize) : 0,
        g;
      for (let p = d + 1; p < n.length; p += 1)
        n[p] &&
          !g &&
          ((f += Math.ceil(n[p].swiperSlideSize)), (m += 1), f > a && (g = !0));
      for (let p = d - 1; p >= 0; p -= 1)
        n[p] &&
          !g &&
          ((f += n[p].swiperSlideSize), (m += 1), f > a && (g = !0));
    } else if (e === "current")
      for (let f = d + 1; f < n.length; f += 1)
        (i ? o[f] + c[f] - o[d] < a : o[f] - o[d] < a) && (m += 1);
    else for (let f = d - 1; f >= 0; f -= 1) o[d] - o[f] < a && (m += 1);
    return m;
  }
  update() {
    const e = this;
    if (!e || e.destroyed) return;
    const { snapGrid: i, params: r } = e;
    (r.breakpoints && e.setBreakpoint(),
      [...e.el.querySelectorAll('[loading="lazy"]')].forEach((o) => {
        o.complete && Le(e, o);
      }),
      e.updateSize(),
      e.updateSlides(),
      e.updateProgress(),
      e.updateSlidesClasses());
    function s() {
      const o = e.rtlTranslate ? e.translate * -1 : e.translate,
        c = Math.min(Math.max(o, e.maxTranslate()), e.minTranslate());
      (e.setTranslate(c), e.updateActiveIndex(), e.updateSlidesClasses());
    }
    let n;
    if (r.freeMode && r.freeMode.enabled && !r.cssMode)
      (s(), r.autoHeight && e.updateAutoHeight());
    else {
      if (
        (r.slidesPerView === "auto" || r.slidesPerView > 1) &&
        e.isEnd &&
        !r.centeredSlides
      ) {
        const o = e.virtual && r.virtual.enabled ? e.virtual.slides : e.slides;
        n = e.slideTo(o.length - 1, 0, !1, !0);
      } else n = e.slideTo(e.activeIndex, 0, !1, !0);
      n || s();
    }
    (r.watchOverflow && i !== e.snapGrid && e.checkOverflow(),
      e.emit("update"));
  }
  changeDirection(e, i = !0) {
    const r = this,
      s = r.params.direction;
    return (
      e || (e = s === "horizontal" ? "vertical" : "horizontal"),
      e === s ||
        (e !== "horizontal" && e !== "vertical") ||
        (r.el.classList.remove(`${r.params.containerModifierClass}${s}`),
        r.el.classList.add(`${r.params.containerModifierClass}${e}`),
        r.emitContainerClasses(),
        (r.params.direction = e),
        r.slides.forEach((n) => {
          e === "vertical" ? (n.style.width = "") : (n.style.height = "");
        }),
        r.emit("changeDirection"),
        i && r.update()),
      r
    );
  }
  changeLanguageDirection(e) {
    const i = this;
    (i.rtl && e === "rtl") ||
      (!i.rtl && e === "ltr") ||
      ((i.rtl = e === "rtl"),
      (i.rtlTranslate = i.params.direction === "horizontal" && i.rtl),
      i.rtl
        ? (i.el.classList.add(`${i.params.containerModifierClass}rtl`),
          (i.el.dir = "rtl"))
        : (i.el.classList.remove(`${i.params.containerModifierClass}rtl`),
          (i.el.dir = "ltr")),
      i.update());
  }
  mount(e) {
    const i = this;
    if (i.mounted) return !0;
    let r = e || i.params.el;
    if ((typeof r == "string" && (r = document.querySelector(r)), !r))
      return !1;
    ((r.swiper = i),
      r.parentNode &&
        r.parentNode.host &&
        r.parentNode.host.nodeName ===
          i.params.swiperElementNodeName.toUpperCase() &&
        (i.isElement = !0));
    const s = () =>
      `.${(i.params.wrapperClass || "").trim().split(" ").join(".")}`;
    let o =
      r && r.shadowRoot && r.shadowRoot.querySelector
        ? r.shadowRoot.querySelector(s())
        : le(r, s())[0];
    return (
      !o &&
        i.params.createElements &&
        ((o = Je("div", i.params.wrapperClass)),
        r.append(o),
        le(r, `.${i.params.slideClass}`).forEach((c) => {
          o.append(c);
        })),
      Object.assign(i, {
        el: r,
        wrapperEl: o,
        slidesEl:
          i.isElement && !r.parentNode.host.slideSlots ? r.parentNode.host : o,
        hostEl: i.isElement ? r.parentNode.host : r,
        mounted: !0,
        rtl: r.dir.toLowerCase() === "rtl" || ue(r, "direction") === "rtl",
        rtlTranslate:
          i.params.direction === "horizontal" &&
          (r.dir.toLowerCase() === "rtl" || ue(r, "direction") === "rtl"),
        wrongRTL: ue(o, "display") === "-webkit-box",
      }),
      !0
    );
  }
  init(e) {
    const i = this;
    if (i.initialized || i.mount(e) === !1) return i;
    (i.emit("beforeInit"),
      i.params.breakpoints && i.setBreakpoint(),
      i.addClasses(),
      i.updateSize(),
      i.updateSlides(),
      i.params.watchOverflow && i.checkOverflow(),
      i.params.grabCursor && i.enabled && i.setGrabCursor(),
      i.params.loop && i.virtual && i.params.virtual.enabled
        ? i.slideTo(
            i.params.initialSlide + i.virtual.slidesBefore,
            0,
            i.params.runCallbacksOnInit,
            !1,
            !0,
          )
        : i.slideTo(
            i.params.initialSlide,
            0,
            i.params.runCallbacksOnInit,
            !1,
            !0,
          ),
      i.params.loop && i.loopCreate(void 0, !0),
      i.attachEvents());
    const s = [...i.el.querySelectorAll('[loading="lazy"]')];
    return (
      i.isElement && s.push(...i.hostEl.querySelectorAll('[loading="lazy"]')),
      s.forEach((n) => {
        n.complete
          ? Le(i, n)
          : n.addEventListener("load", (o) => {
              Le(i, o.target);
            });
      }),
      Ze(i),
      (i.initialized = !0),
      Ze(i),
      i.emit("init"),
      i.emit("afterInit"),
      i
    );
  }
  destroy(e = !0, i = !0) {
    const r = this,
      { params: s, el: n, wrapperEl: o, slides: c } = r;
    return (
      typeof r.params > "u" ||
        r.destroyed ||
        (r.emit("beforeDestroy"),
        (r.initialized = !1),
        r.detachEvents(),
        s.loop && r.loopDestroy(),
        i &&
          (r.removeClasses(),
          n && typeof n != "string" && n.removeAttribute("style"),
          o && o.removeAttribute("style"),
          c &&
            c.length &&
            c.forEach((a) => {
              (a.classList.remove(
                s.slideVisibleClass,
                s.slideFullyVisibleClass,
                s.slideActiveClass,
                s.slideNextClass,
                s.slidePrevClass,
              ),
                a.removeAttribute("style"),
                a.removeAttribute("data-swiper-slide-index"));
            })),
        r.emit("destroy"),
        Object.keys(r.eventsListeners).forEach((a) => {
          r.off(a);
        }),
        e !== !1 &&
          (r.el && typeof r.el != "string" && (r.el.swiper = null), Si(r)),
        (r.destroyed = !0)),
      null
    );
  }
  static extendDefaults(e) {
    ie(Qe, e);
  }
  static get extendedDefaults() {
    return Qe;
  }
  static get defaults() {
    return Et;
  }
  static installModule(e) {
    re.prototype.__modules__ || (re.prototype.__modules__ = []);
    const i = re.prototype.__modules__;
    typeof e == "function" && i.indexOf(e) < 0 && i.push(e);
  }
  static use(e) {
    return Array.isArray(e)
      ? (e.forEach((i) => re.installModule(i)), re)
      : (re.installModule(e), re);
  }
}
Object.keys(Ke).forEach((t) => {
  Object.keys(Ke[t]).forEach((e) => {
    re.prototype[e] = Ke[t][e];
  });
});
re.use([ki, Ii]);
new re(".cases-slider", {
  modules: [],
  slidesPerView: 1,
  spaceBetween: 10,
  breakpoints: {
    360: { slidesPerView: 1.2 },
    640: { slidesPerView: 2.2 },
    1024: { slidesPerView: 3 },
    1300: { slidesPerView: 4.3 },
  },
});
const Dr = document.querySelectorAll("[data-type-choose]");
Dr.forEach((t) => {
  t.addEventListener("click", (e) => {
    const i = t.dataset.typeChoose;
    document
      .querySelectorAll(`[data-type]:not([data-type="${i}"])`)
      .forEach((s) => {
        s.remove();
      });
  });
});
const Ct = document.getElementById("calc");
let ae = -1;
const we = document.querySelectorAll(".calc__step"),
  et = document.querySelector(".calc__progress");
Ct &&
  Ct.querySelectorAll("input[data-next-step]").forEach((e) => {
    e.addEventListener("change", (i) => {
      i.target.value &&
        (ae >= 0 && we[ae].classList.remove("calc__step_active"),
        (ae += 1),
        we[ae].classList.add("calc__step_active"),
        (et.style.width = `${(ae / 5) * 100}%`));
    });
  });
const Pt = document.querySelectorAll("[data-calc-subform]");
Pt.length > 0 &&
  we &&
  et &&
  Pt.forEach((t) => {
    const e = t.querySelectorAll("input[required]"),
      i = t.querySelector("[data-subform-submit]");
    (i.removeAttribute("disabled"),
      e.forEach((r) => {
        (console.log(r.value),
          (!r.value || !r.checked) && i.setAttribute("disabled", "disabled"),
          r.addEventListener("input", () => {
            (i.removeAttribute("disabled"),
              e.forEach((s) => {
                s.value || i.setAttribute("disabled", "disabled");
              }));
          }));
      }),
      i.addEventListener("click", () => {
        i.disabled ||
          (i.insertAdjacentHTML(
            "afterend",
            '<input type="radio" checked data-next-step>',
          ),
          ae >= 0 && we[ae].classList.remove("calc__step_active"),
          (ae += 1),
          we[ae].classList.add("calc__step_active"),
          (et.style.width = `${(ae / 5) * 100}%`));
      }));
  });
const he = document.querySelectorAll(".configurator__tab"),
  Mt = document.querySelectorAll(".configurator__pane"),
  Lt = ["size-type", "mounting", "color"];
if (he.length > 0 && Mt.length > 0) {
  const t = document.querySelector(".configurator__button.button_backarrow"),
    e = document.querySelector(".configurator__button.button_arrow"),
    i = (n, o) => {
      (he.forEach((a) => {
        a.classList.remove("configurator__tab_active");
      }),
        Mt.forEach((a) => {
          a.classList.remove("configurator__pane_active");
        }),
        n.classList.add("configurator__tab_active"));
      const c = document.getElementById(o);
      c && c.classList.add("configurator__pane_active");
    };
  he.forEach((n) => {
    n.addEventListener("click", (o) => {
      const c = o.currentTarget,
        a = c.getAttribute("data-target");
      i(c, a);
    });
  });
  const r = () =>
    Array.from(he).findIndex((n) =>
      n.classList.contains("configurator__tab_active"),
    );
  (e.addEventListener("click", () => {
    const n = r();
    if (n < he.length - 1) {
      const o = n + 1;
      i(he[o], Lt[o]);
    }
  }),
    t.addEventListener("click", () => {
      const n = r();
      if (n > 0) {
        const o = n - 1;
        i(he[o], Lt[o]);
      }
    }));
  const s = document.querySelector(".quantity-control");
  if (s) {
    const n = s.querySelector(".quantity-control__input"),
      o = s.querySelector(".quantity-control__btn:first-child");
    (s
      .querySelector(".quantity-control__btn:last-child")
      .addEventListener("click", () => {
        n.value = parseInt(n.value) + 1;
      }),
      o.addEventListener("click", () => {
        const a = parseInt(n.value);
        a > 1 && (n.value = a - 1);
      }));
  }
}
const At = document.querySelectorAll(".config-mounting__input"),
  Se = document.getElementById("mounting-desc");
if (At.length > 0 && Se) {
  const t = (e) => {
    e.checked &&
      ((Se.style.opacity = 0),
      setTimeout(() => {
        ((Se.textContent = e.dataset.description), (Se.style.opacity = 1));
      }, 150));
  };
  At.forEach((e) => {
    (e.addEventListener("change", () => t(e)),
      e.checked && (Se.textContent = e.dataset.description));
  });
}
var ce;
(function (t) {
  ((t.Range = "range"),
    (t.Steps = "steps"),
    (t.Positions = "positions"),
    (t.Count = "count"),
    (t.Values = "values"));
})(ce || (ce = {}));
var J;
(function (t) {
  ((t[(t.None = -1)] = "None"),
    (t[(t.NoValue = 0)] = "NoValue"),
    (t[(t.LargeValue = 1)] = "LargeValue"),
    (t[(t.SmallValue = 2)] = "SmallValue"));
})(J || (J = {}));
function Gr(t) {
  return Oe(t) && typeof t.from == "function";
}
function Oe(t) {
  return typeof t == "object" && typeof t.to == "function";
}
function kt(t) {
  t.parentElement.removeChild(t);
}
function tt(t) {
  return t != null;
}
function It(t) {
  t.preventDefault();
}
function Br(t) {
  return t.filter(function (e) {
    return this[e] ? !1 : (this[e] = !0);
  }, {});
}
function Fr(t, e) {
  return Math.round(t / e) * e;
}
function Hr(t, e) {
  var i = t.getBoundingClientRect(),
    r = t.ownerDocument,
    s = r.documentElement,
    n = $t(r);
  return (
    /webkit.*Chrome.*Mobile/i.test(navigator.userAgent) && (n.x = 0),
    e ? i.top + n.y - s.clientTop : i.left + n.x - s.clientLeft
  );
}
function se(t) {
  return typeof t == "number" && !isNaN(t) && isFinite(t);
}
function Ot(t, e, i) {
  i > 0 &&
    (Q(t, e),
    setTimeout(function () {
      Ae(t, e);
    }, i));
}
function _t(t) {
  return Math.max(Math.min(t, 100), 0);
}
function _e(t) {
  return Array.isArray(t) ? t : [t];
}
function Nr(t) {
  t = String(t);
  var e = t.split(".");
  return e.length > 1 ? e[1].length : 0;
}
function Q(t, e) {
  t.classList && !/\s/.test(e) ? t.classList.add(e) : (t.className += " " + e);
}
function Ae(t, e) {
  t.classList && !/\s/.test(e)
    ? t.classList.remove(e)
    : (t.className = t.className.replace(
        new RegExp("(^|\\b)" + e.split(" ").join("|") + "(\\b|$)", "gi"),
        " ",
      ));
}
function Rr(t, e) {
  return t.classList
    ? t.classList.contains(e)
    : new RegExp("\\b" + e + "\\b").test(t.className);
}
function $t(t) {
  var e = window.pageXOffset !== void 0,
    i = (t.compatMode || "") === "CSS1Compat",
    r = e
      ? window.pageXOffset
      : i
        ? t.documentElement.scrollLeft
        : t.body.scrollLeft,
    s = e
      ? window.pageYOffset
      : i
        ? t.documentElement.scrollTop
        : t.body.scrollTop;
  return { x: r, y: s };
}
function jr() {
  return window.navigator.pointerEnabled
    ? { start: "pointerdown", move: "pointermove", end: "pointerup" }
    : window.navigator.msPointerEnabled
      ? { start: "MSPointerDown", move: "MSPointerMove", end: "MSPointerUp" }
      : {
          start: "mousedown touchstart",
          move: "mousemove touchmove",
          end: "mouseup touchend",
        };
}
function qr() {
  var t = !1;
  try {
    var e = Object.defineProperty({}, "passive", {
      get: function () {
        t = !0;
      },
    });
    window.addEventListener("test", null, e);
  } catch {}
  return t;
}
function $r() {
  return window.CSS && CSS.supports && CSS.supports("touch-action", "none");
}
function st(t, e) {
  return 100 / (e - t);
}
function it(t, e, i) {
  return (e * 100) / (t[i + 1] - t[i]);
}
function Wr(t, e) {
  return it(t, t[0] < 0 ? e + Math.abs(t[0]) : e - t[0], 0);
}
function Ur(t, e) {
  return (e * (t[1] - t[0])) / 100 + t[0];
}
function be(t, e) {
  for (var i = 1; t >= e[i]; ) i += 1;
  return i;
}
function Xr(t, e, i) {
  if (i >= t.slice(-1)[0]) return 100;
  var r = be(i, t),
    s = t[r - 1],
    n = t[r],
    o = e[r - 1],
    c = e[r];
  return o + Wr([s, n], i) / st(o, c);
}
function Yr(t, e, i) {
  if (i >= 100) return t.slice(-1)[0];
  var r = be(i, e),
    s = t[r - 1],
    n = t[r],
    o = e[r - 1],
    c = e[r];
  return Ur([s, n], (i - o) * st(o, c));
}
function Kr(t, e, i, r) {
  if (r === 100) return r;
  var s = be(r, t),
    n = t[s - 1],
    o = t[s];
  return i
    ? r - n > (o - n) / 2
      ? o
      : n
    : e[s - 1]
      ? t[s - 1] + Fr(r - t[s - 1], e[s - 1])
      : r;
}
var Wt = (function () {
    function t(e, i, r) {
      ((this.xPct = []),
        (this.xVal = []),
        (this.xSteps = []),
        (this.xNumSteps = []),
        (this.xHighestCompleteStep = []),
        (this.xSteps = [r || !1]),
        (this.xNumSteps = [!1]),
        (this.snap = i));
      var s,
        n = [];
      for (
        Object.keys(e).forEach(function (o) {
          n.push([_e(e[o]), o]);
        }),
          n.sort(function (o, c) {
            return o[0][0] - c[0][0];
          }),
          s = 0;
        s < n.length;
        s++
      )
        this.handleEntryPoint(n[s][1], n[s][0]);
      for (
        this.xNumSteps = this.xSteps.slice(0), s = 0;
        s < this.xNumSteps.length;
        s++
      )
        this.handleStepPoint(s, this.xNumSteps[s]);
    }
    return (
      (t.prototype.getDistance = function (e) {
        for (var i = [], r = 0; r < this.xNumSteps.length - 1; r++)
          i[r] = it(this.xVal, e, r);
        return i;
      }),
      (t.prototype.getAbsoluteDistance = function (e, i, r) {
        var s = 0;
        if (e < this.xPct[this.xPct.length - 1])
          for (; e > this.xPct[s + 1]; ) s++;
        else
          e === this.xPct[this.xPct.length - 1] && (s = this.xPct.length - 2);
        (!r && e === this.xPct[s + 1] && s++, i === null && (i = []));
        var n,
          o = 1,
          c = i[s],
          a = 0,
          d = 0,
          m = 0,
          f = 0;
        for (
          r
            ? (n = (e - this.xPct[s]) / (this.xPct[s + 1] - this.xPct[s]))
            : (n = (this.xPct[s + 1] - e) / (this.xPct[s + 1] - this.xPct[s]));
          c > 0;
        )
          ((a = this.xPct[s + 1 + f] - this.xPct[s + f]),
            i[s + f] * o + 100 - n * 100 > 100
              ? ((d = a * n), (o = (c - 100 * n) / i[s + f]), (n = 1))
              : ((d = ((i[s + f] * a) / 100) * o), (o = 0)),
            r
              ? ((m = m - d), this.xPct.length + f >= 1 && f--)
              : ((m = m + d), this.xPct.length - f >= 1 && f++),
            (c = i[s + f] * o));
        return e + m;
      }),
      (t.prototype.toStepping = function (e) {
        return ((e = Xr(this.xVal, this.xPct, e)), e);
      }),
      (t.prototype.fromStepping = function (e) {
        return Yr(this.xVal, this.xPct, e);
      }),
      (t.prototype.getStep = function (e) {
        return ((e = Kr(this.xPct, this.xSteps, this.snap, e)), e);
      }),
      (t.prototype.getDefaultStep = function (e, i, r) {
        var s = be(e, this.xPct);
        return (
          (e === 100 || (i && e === this.xPct[s - 1])) &&
            (s = Math.max(s - 1, 1)),
          (this.xVal[s] - this.xVal[s - 1]) / r
        );
      }),
      (t.prototype.getNearbySteps = function (e) {
        var i = be(e, this.xPct);
        return {
          stepBefore: {
            startValue: this.xVal[i - 2],
            step: this.xNumSteps[i - 2],
            highestStep: this.xHighestCompleteStep[i - 2],
          },
          thisStep: {
            startValue: this.xVal[i - 1],
            step: this.xNumSteps[i - 1],
            highestStep: this.xHighestCompleteStep[i - 1],
          },
          stepAfter: {
            startValue: this.xVal[i],
            step: this.xNumSteps[i],
            highestStep: this.xHighestCompleteStep[i],
          },
        };
      }),
      (t.prototype.countStepDecimals = function () {
        var e = this.xNumSteps.map(Nr);
        return Math.max.apply(null, e);
      }),
      (t.prototype.hasNoSize = function () {
        return this.xVal[0] === this.xVal[this.xVal.length - 1];
      }),
      (t.prototype.convert = function (e) {
        return this.getStep(this.toStepping(e));
      }),
      (t.prototype.handleEntryPoint = function (e, i) {
        var r;
        if (
          (e === "min"
            ? (r = 0)
            : e === "max"
              ? (r = 100)
              : (r = parseFloat(e)),
          !se(r) || !se(i[0]))
        )
          throw new Error("noUiSlider: 'range' value isn't numeric.");
        (this.xPct.push(r), this.xVal.push(i[0]));
        var s = Number(i[1]);
        (r
          ? this.xSteps.push(isNaN(s) ? !1 : s)
          : isNaN(s) || (this.xSteps[0] = s),
          this.xHighestCompleteStep.push(0));
      }),
      (t.prototype.handleStepPoint = function (e, i) {
        if (i) {
          if (this.xVal[e] === this.xVal[e + 1]) {
            this.xSteps[e] = this.xHighestCompleteStep[e] = this.xVal[e];
            return;
          }
          this.xSteps[e] =
            it([this.xVal[e], this.xVal[e + 1]], i, 0) /
            st(this.xPct[e], this.xPct[e + 1]);
          var r = (this.xVal[e + 1] - this.xVal[e]) / this.xNumSteps[e],
            s = Math.ceil(Number(r.toFixed(3)) - 1),
            n = this.xVal[e] + this.xNumSteps[e] * s;
          this.xHighestCompleteStep[e] = n;
        }
      }),
      t
    );
  })(),
  Vt = {
    to: function (t) {
      return t === void 0 ? "" : t.toFixed(2);
    },
    from: Number,
  },
  Ut = {
    target: "target",
    base: "base",
    origin: "origin",
    handle: "handle",
    handleLower: "handle-lower",
    handleUpper: "handle-upper",
    touchArea: "touch-area",
    horizontal: "horizontal",
    vertical: "vertical",
    background: "background",
    connect: "connect",
    connects: "connects",
    ltr: "ltr",
    rtl: "rtl",
    textDirectionLtr: "txt-dir-ltr",
    textDirectionRtl: "txt-dir-rtl",
    draggable: "draggable",
    drag: "state-drag",
    tap: "state-tap",
    active: "active",
    tooltip: "tooltip",
    pips: "pips",
    pipsHorizontal: "pips-horizontal",
    pipsVertical: "pips-vertical",
    marker: "marker",
    markerHorizontal: "marker-horizontal",
    markerVertical: "marker-vertical",
    markerNormal: "marker-normal",
    markerLarge: "marker-large",
    markerSub: "marker-sub",
    value: "value",
    valueHorizontal: "value-horizontal",
    valueVertical: "value-vertical",
    valueNormal: "value-normal",
    valueLarge: "value-large",
    valueSub: "value-sub",
  },
  de = { tooltips: ".__tooltips", aria: ".__aria" };
function Qr(t, e) {
  if (!se(e)) throw new Error("noUiSlider: 'step' is not numeric.");
  t.singleStep = e;
}
function Jr(t, e) {
  if (!se(e))
    throw new Error("noUiSlider: 'keyboardPageMultiplier' is not numeric.");
  t.keyboardPageMultiplier = e;
}
function Zr(t, e) {
  if (!se(e))
    throw new Error("noUiSlider: 'keyboardMultiplier' is not numeric.");
  t.keyboardMultiplier = e;
}
function es(t, e) {
  if (!se(e))
    throw new Error("noUiSlider: 'keyboardDefaultStep' is not numeric.");
  t.keyboardDefaultStep = e;
}
function ts(t, e) {
  if (typeof e != "object" || Array.isArray(e))
    throw new Error("noUiSlider: 'range' is not an object.");
  if (e.min === void 0 || e.max === void 0)
    throw new Error("noUiSlider: Missing 'min' or 'max' in 'range'.");
  t.spectrum = new Wt(e, t.snap || !1, t.singleStep);
}
function is(t, e) {
  if (((e = _e(e)), !Array.isArray(e) || !e.length))
    throw new Error("noUiSlider: 'start' option is incorrect.");
  ((t.handles = e.length), (t.start = e));
}
function rs(t, e) {
  if (typeof e != "boolean")
    throw new Error("noUiSlider: 'snap' option must be a boolean.");
  t.snap = e;
}
function ss(t, e) {
  if (typeof e != "boolean")
    throw new Error("noUiSlider: 'animate' option must be a boolean.");
  t.animate = e;
}
function ns(t, e) {
  if (typeof e != "number")
    throw new Error("noUiSlider: 'animationDuration' option must be a number.");
  t.animationDuration = e;
}
function Xt(t, e) {
  var i = [!1],
    r;
  if (
    (e === "lower" ? (e = [!0, !1]) : e === "upper" && (e = [!1, !0]),
    e === !0 || e === !1)
  ) {
    for (r = 1; r < t.handles; r++) i.push(e);
    i.push(!1);
  } else {
    if (!Array.isArray(e) || !e.length || e.length !== t.handles + 1)
      throw new Error(
        "noUiSlider: 'connect' option doesn't match handle count.",
      );
    i = e;
  }
  t.connect = i;
}
function as(t, e) {
  switch (e) {
    case "horizontal":
      t.ort = 0;
      break;
    case "vertical":
      t.ort = 1;
      break;
    default:
      throw new Error("noUiSlider: 'orientation' option is invalid.");
  }
}
function Yt(t, e) {
  if (!se(e)) throw new Error("noUiSlider: 'margin' option must be numeric.");
  e !== 0 && (t.margin = t.spectrum.getDistance(e));
}
function os(t, e) {
  if (!se(e)) throw new Error("noUiSlider: 'limit' option must be numeric.");
  if (((t.limit = t.spectrum.getDistance(e)), !t.limit || t.handles < 2))
    throw new Error(
      "noUiSlider: 'limit' option is only supported on linear sliders with 2 or more handles.",
    );
}
function ls(t, e) {
  var i;
  if (!se(e) && !Array.isArray(e))
    throw new Error(
      "noUiSlider: 'padding' option must be numeric or array of exactly 2 numbers.",
    );
  if (Array.isArray(e) && !(e.length === 2 || se(e[0]) || se(e[1])))
    throw new Error(
      "noUiSlider: 'padding' option must be numeric or array of exactly 2 numbers.",
    );
  if (e !== 0) {
    for (
      Array.isArray(e) || (e = [e, e]),
        t.padding = [
          t.spectrum.getDistance(e[0]),
          t.spectrum.getDistance(e[1]),
        ],
        i = 0;
      i < t.spectrum.xNumSteps.length - 1;
      i++
    )
      if (t.padding[0][i] < 0 || t.padding[1][i] < 0)
        throw new Error(
          "noUiSlider: 'padding' option must be a positive number(s).",
        );
    var r = e[0] + e[1],
      s = t.spectrum.xVal[0],
      n = t.spectrum.xVal[t.spectrum.xVal.length - 1];
    if (r / (n - s) > 1)
      throw new Error(
        "noUiSlider: 'padding' option must not exceed 100% of the range.",
      );
  }
}
function ds(t, e) {
  switch (e) {
    case "ltr":
      t.dir = 0;
      break;
    case "rtl":
      t.dir = 1;
      break;
    default:
      throw new Error("noUiSlider: 'direction' option was not recognized.");
  }
}
function cs(t, e) {
  if (typeof e != "string")
    throw new Error(
      "noUiSlider: 'behaviour' must be a string containing options.",
    );
  var i = e.indexOf("tap") >= 0,
    r = e.indexOf("drag") >= 0,
    s = e.indexOf("fixed") >= 0,
    n = e.indexOf("snap") >= 0,
    o = e.indexOf("hover") >= 0,
    c = e.indexOf("unconstrained") >= 0,
    a = e.indexOf("invert-connects") >= 0,
    d = e.indexOf("drag-all") >= 0,
    m = e.indexOf("smooth-steps") >= 0;
  if (s) {
    if (t.handles !== 2)
      throw new Error(
        "noUiSlider: 'fixed' behaviour must be used with 2 handles",
      );
    Yt(t, t.start[1] - t.start[0]);
  }
  if (a && t.handles !== 2)
    throw new Error(
      "noUiSlider: 'invert-connects' behaviour must be used with 2 handles",
    );
  if (c && (t.margin || t.limit))
    throw new Error(
      "noUiSlider: 'unconstrained' behaviour cannot be used with margin or limit",
    );
  t.events = {
    tap: i || n,
    drag: r,
    dragAll: d,
    smoothSteps: m,
    fixed: s,
    snap: n,
    hover: o,
    unconstrained: c,
    invertConnects: a,
  };
}
function us(t, e) {
  if (e !== !1)
    if (e === !0 || Oe(e)) {
      t.tooltips = [];
      for (var i = 0; i < t.handles; i++) t.tooltips.push(e);
    } else {
      if (((e = _e(e)), e.length !== t.handles))
        throw new Error("noUiSlider: must pass a formatter for all handles.");
      (e.forEach(function (r) {
        if (typeof r != "boolean" && !Oe(r))
          throw new Error(
            "noUiSlider: 'tooltips' must be passed a formatter or 'false'.",
          );
      }),
        (t.tooltips = e));
    }
}
function fs(t, e) {
  if (e.length !== t.handles)
    throw new Error("noUiSlider: must pass a attributes for all handles.");
  t.handleAttributes = e;
}
function ps(t, e) {
  if (!Oe(e)) throw new Error("noUiSlider: 'ariaFormat' requires 'to' method.");
  t.ariaFormat = e;
}
function hs(t, e) {
  if (!Gr(e))
    throw new Error("noUiSlider: 'format' requires 'to' and 'from' methods.");
  t.format = e;
}
function ms(t, e) {
  if (typeof e != "boolean")
    throw new Error("noUiSlider: 'keyboardSupport' option must be a boolean.");
  t.keyboardSupport = e;
}
function gs(t, e) {
  t.documentElement = e;
}
function vs(t, e) {
  if (typeof e != "string" && e !== !1)
    throw new Error("noUiSlider: 'cssPrefix' must be a string or `false`.");
  t.cssPrefix = e;
}
function Ss(t, e) {
  if (typeof e != "object")
    throw new Error("noUiSlider: 'cssClasses' must be an object.");
  typeof t.cssPrefix == "string"
    ? ((t.cssClasses = {}),
      Object.keys(e).forEach(function (i) {
        t.cssClasses[i] = t.cssPrefix + e[i];
      }))
    : (t.cssClasses = e);
}
function Kt(t) {
  var e = {
      margin: null,
      limit: null,
      padding: null,
      animate: !0,
      animationDuration: 300,
      ariaFormat: Vt,
      format: Vt,
    },
    i = {
      step: { r: !1, t: Qr },
      keyboardPageMultiplier: { r: !1, t: Jr },
      keyboardMultiplier: { r: !1, t: Zr },
      keyboardDefaultStep: { r: !1, t: es },
      start: { r: !0, t: is },
      connect: { r: !0, t: Xt },
      direction: { r: !0, t: ds },
      snap: { r: !1, t: rs },
      animate: { r: !1, t: ss },
      animationDuration: { r: !1, t: ns },
      range: { r: !0, t: ts },
      orientation: { r: !1, t: as },
      margin: { r: !1, t: Yt },
      limit: { r: !1, t: os },
      padding: { r: !1, t: ls },
      behaviour: { r: !0, t: cs },
      ariaFormat: { r: !1, t: ps },
      format: { r: !1, t: hs },
      tooltips: { r: !1, t: us },
      keyboardSupport: { r: !0, t: ms },
      documentElement: { r: !1, t: gs },
      cssPrefix: { r: !0, t: vs },
      cssClasses: { r: !0, t: Ss },
      handleAttributes: { r: !1, t: fs },
    },
    r = {
      connect: !1,
      direction: "ltr",
      behaviour: "tap",
      orientation: "horizontal",
      keyboardSupport: !0,
      cssPrefix: "noUi-",
      cssClasses: Ut,
      keyboardPageMultiplier: 5,
      keyboardMultiplier: 1,
      keyboardDefaultStep: 10,
    };
  (t.format && !t.ariaFormat && (t.ariaFormat = t.format),
    Object.keys(i).forEach(function (a) {
      if (!tt(t[a]) && r[a] === void 0) {
        if (i[a].r) throw new Error("noUiSlider: '" + a + "' is required.");
        return;
      }
      i[a].t(e, tt(t[a]) ? t[a] : r[a]);
    }),
    (e.pips = t.pips));
  var s = document.createElement("div"),
    n = s.style.msTransform !== void 0,
    o = s.style.transform !== void 0;
  e.transformRule = o ? "transform" : n ? "msTransform" : "webkitTransform";
  var c = [
    ["left", "top"],
    ["right", "bottom"],
  ];
  return ((e.style = c[e.dir][e.ort]), e);
}
function ws(t, e, i) {
  var r = jr(),
    s = $r(),
    n = s && qr(),
    o = t,
    c,
    a,
    d,
    m,
    f,
    g,
    p = e.spectrum,
    w = [],
    S = [],
    L = [],
    I = 0,
    y = {},
    E = !1,
    O = t.ownerDocument,
    P = e.documentElement || O.documentElement,
    D = O.body,
    z = O.dir === "rtl" || e.ort === 1 ? 0 : 100;
  function C(l, u) {
    var h = O.createElement("div");
    return (u && Q(h, u), l.appendChild(h), h);
  }
  function $(l, u) {
    var h = C(l, e.cssClasses.origin),
      v = C(h, e.cssClasses.handle);
    if (
      (C(v, e.cssClasses.touchArea),
      v.setAttribute("data-handle", String(u)),
      e.keyboardSupport &&
        (v.setAttribute("tabindex", "0"),
        v.addEventListener("keydown", function (x) {
          return ni(x, u);
        })),
      e.handleAttributes !== void 0)
    ) {
      var b = e.handleAttributes[u];
      Object.keys(b).forEach(function (x) {
        v.setAttribute(x, b[x]);
      });
    }
    return (
      v.setAttribute("role", "slider"),
      v.setAttribute("aria-orientation", e.ort ? "vertical" : "horizontal"),
      u === 0
        ? Q(v, e.cssClasses.handleLower)
        : u === e.handles - 1 && Q(v, e.cssClasses.handleUpper),
      (h.handle = v),
      h
    );
  }
  function A(l, u) {
    return u ? C(l, e.cssClasses.connect) : !1;
  }
  function M(l, u) {
    ((a = C(u, e.cssClasses.connects)), (d = []), (m = []), m.push(A(a, l[0])));
    for (var h = 0; h < e.handles; h++)
      (d.push($(u, h)), (L[h] = h), m.push(A(a, l[h + 1])));
  }
  function V(l) {
    (Q(l, e.cssClasses.target),
      e.dir === 0 ? Q(l, e.cssClasses.ltr) : Q(l, e.cssClasses.rtl),
      e.ort === 0
        ? Q(l, e.cssClasses.horizontal)
        : Q(l, e.cssClasses.vertical));
    var u = getComputedStyle(l).direction;
    return (
      u === "rtl"
        ? Q(l, e.cssClasses.textDirectionRtl)
        : Q(l, e.cssClasses.textDirectionLtr),
      C(l, e.cssClasses.base)
    );
  }
  function X(l, u) {
    return !e.tooltips || !e.tooltips[u]
      ? !1
      : C(l.firstChild, e.cssClasses.tooltip);
  }
  function ee() {
    return o.hasAttribute("disabled");
  }
  function te(l) {
    var u = d[l];
    return u.hasAttribute("disabled");
  }
  function xe(l) {
    l != null
      ? (d[l].setAttribute("disabled", ""),
        d[l].handle.removeAttribute("tabindex"))
      : (o.setAttribute("disabled", ""),
        d.forEach(function (u) {
          u.handle.removeAttribute("tabindex");
        }));
  }
  function oe(l) {
    l != null
      ? (d[l].removeAttribute("disabled"),
        d[l].handle.setAttribute("tabindex", "0"))
      : (o.removeAttribute("disabled"),
        d.forEach(function (u) {
          (u.removeAttribute("disabled"),
            u.handle.setAttribute("tabindex", "0"));
        }));
  }
  function _() {
    g &&
      (ge("update" + de.tooltips),
      g.forEach(function (l) {
        l && kt(l);
      }),
      (g = null));
  }
  function j() {
    (_(),
      (g = d.map(X)),
      Be("update" + de.tooltips, function (l, u, h) {
        if (!(!g || !e.tooltips) && g[u] !== !1) {
          var v = l[u];
          (e.tooltips[u] !== !0 && (v = e.tooltips[u].to(h[u])),
            (g[u].innerHTML = v));
        }
      }));
  }
  function Y() {
    (ge("update" + de.aria),
      Be("update" + de.aria, function (l, u, h, v, b) {
        L.forEach(function (x) {
          var k = d[x],
            T = Te(S, x, 0, !0, !0, !0),
            B = Te(S, x, 100, !0, !0, !0),
            F = b[x],
            H = String(e.ariaFormat.to(h[x]));
          ((T = p.fromStepping(T).toFixed(1)),
            (B = p.fromStepping(B).toFixed(1)),
            (F = p.fromStepping(F).toFixed(1)),
            k.children[0].setAttribute("aria-valuemin", T),
            k.children[0].setAttribute("aria-valuemax", B),
            k.children[0].setAttribute("aria-valuenow", F),
            k.children[0].setAttribute("aria-valuetext", H));
        });
      }));
  }
  function ne(l) {
    if (l.mode === ce.Range || l.mode === ce.Steps) return p.xVal;
    if (l.mode === ce.Count) {
      if (l.values < 2)
        throw new Error(
          "noUiSlider: 'values' (>= 2) required for mode 'count'.",
        );
      for (var u = l.values - 1, h = 100 / u, v = []; u--; ) v[u] = u * h;
      return (v.push(100), ye(v, l.stepped));
    }
    return l.mode === ce.Positions
      ? ye(l.values, l.stepped)
      : l.mode === ce.Values
        ? l.stepped
          ? l.values.map(function (b) {
              return p.fromStepping(p.getStep(p.toStepping(b)));
            })
          : l.values
        : [];
  }
  function ye(l, u) {
    return l.map(function (h) {
      return p.fromStepping(u ? p.getStep(h) : h);
    });
  }
  function Qt(l) {
    function u(F, H) {
      return Number((F + H).toFixed(7));
    }
    var h = ne(l),
      v = {},
      b = p.xVal[0],
      x = p.xVal[p.xVal.length - 1],
      k = !1,
      T = !1,
      B = 0;
    return (
      (h = Br(
        h.slice().sort(function (F, H) {
          return F - H;
        }),
      )),
      h[0] !== b && (h.unshift(b), (k = !0)),
      h[h.length - 1] !== x && (h.push(x), (T = !0)),
      h.forEach(function (F, H) {
        var N,
          G,
          q,
          K = F,
          W = h[H + 1],
          U,
          Ne,
          Re,
          je,
          ht,
          qe,
          mt,
          gt = l.mode === ce.Steps;
        for (
          gt && (N = p.xNumSteps[H]),
            N || (N = W - K),
            W === void 0 && (W = K),
            N = Math.max(N, 1e-7),
            G = K;
          G <= W;
          G = u(G, N)
        ) {
          for (
            U = p.toStepping(G),
              Ne = U - B,
              ht = Ne / (l.density || 1),
              qe = Math.round(ht),
              mt = Ne / qe,
              q = 1;
            q <= qe;
            q += 1
          )
            ((Re = B + q * mt), (v[Re.toFixed(5)] = [p.fromStepping(Re), 0]));
          ((je =
            h.indexOf(G) > -1 ? J.LargeValue : gt ? J.SmallValue : J.NoValue),
            !H && k && G !== W && (je = 0),
            (G === W && T) || (v[U.toFixed(5)] = [G, je]),
            (B = U));
        }
      }),
      v
    );
  }
  function Jt(l, u, h) {
    var v,
      b,
      x = O.createElement("div"),
      k =
        ((v = {}),
        (v[J.None] = ""),
        (v[J.NoValue] = e.cssClasses.valueNormal),
        (v[J.LargeValue] = e.cssClasses.valueLarge),
        (v[J.SmallValue] = e.cssClasses.valueSub),
        v),
      T =
        ((b = {}),
        (b[J.None] = ""),
        (b[J.NoValue] = e.cssClasses.markerNormal),
        (b[J.LargeValue] = e.cssClasses.markerLarge),
        (b[J.SmallValue] = e.cssClasses.markerSub),
        b),
      B = [e.cssClasses.valueHorizontal, e.cssClasses.valueVertical],
      F = [e.cssClasses.markerHorizontal, e.cssClasses.markerVertical];
    (Q(x, e.cssClasses.pips),
      Q(
        x,
        e.ort === 0 ? e.cssClasses.pipsHorizontal : e.cssClasses.pipsVertical,
      ));
    function H(G, q) {
      var K = q === e.cssClasses.value,
        W = K ? B : F,
        U = K ? k : T;
      return q + " " + W[e.ort] + " " + U[G];
    }
    function N(G, q, K) {
      if (((K = u ? u(q, K) : K), K !== J.None)) {
        var W = C(x, !1);
        ((W.className = H(K, e.cssClasses.marker)),
          (W.style[e.style] = G + "%"),
          K > J.NoValue &&
            ((W = C(x, !1)),
            (W.className = H(K, e.cssClasses.value)),
            W.setAttribute("data-value", String(q)),
            (W.style[e.style] = G + "%"),
            (W.innerHTML = String(h.to(q)))));
      }
    }
    return (
      Object.keys(l).forEach(function (G) {
        N(G, l[G][0], l[G][1]);
      }),
      x
    );
  }
  function Ve() {
    f && (kt(f), (f = null));
  }
  function ze(l) {
    Ve();
    var u = Qt(l),
      h = l.filter,
      v = l.format || {
        to: function (b) {
          return String(Math.round(b));
        },
      };
    return ((f = o.appendChild(Jt(u, h, v))), f);
  }
  function nt() {
    var l = c.getBoundingClientRect(),
      u = "offset" + ["Width", "Height"][e.ort];
    return e.ort === 0 ? l.width || c[u] : l.height || c[u];
  }
  function fe(l, u, h, v) {
    var b = function (k) {
        var T = Zt(k, v.pageOffset, v.target || u);
        if (
          !T ||
          (ee() && !v.doNotReject) ||
          (Rr(o, e.cssClasses.tap) && !v.doNotReject) ||
          (l === r.start && T.buttons !== void 0 && T.buttons > 1) ||
          (v.hover && T.buttons)
        )
          return !1;
        (n || T.preventDefault(), (T.calcPoint = T.points[e.ort]), h(T, v));
      },
      x = [];
    return (
      l.split(" ").forEach(function (k) {
        (u.addEventListener(k, b, n ? { passive: !0 } : !1), x.push([k, b]));
      }),
      x
    );
  }
  function Zt(l, u, h) {
    var v = l.type.indexOf("touch") === 0,
      b = l.type.indexOf("mouse") === 0,
      x = l.type.indexOf("pointer") === 0,
      k = 0,
      T = 0;
    if (
      (l.type.indexOf("MSPointer") === 0 && (x = !0),
      l.type === "mousedown" && !l.buttons && !l.touches)
    )
      return !1;
    if (v) {
      var B = function (N) {
        var G = N.target;
        return (
          G === h ||
          h.contains(G) ||
          (l.composed && l.composedPath().shift() === h)
        );
      };
      if (l.type === "touchstart") {
        var F = Array.prototype.filter.call(l.touches, B);
        if (F.length > 1) return !1;
        ((k = F[0].pageX), (T = F[0].pageY));
      } else {
        var H = Array.prototype.find.call(l.changedTouches, B);
        if (!H) return !1;
        ((k = H.pageX), (T = H.pageY));
      }
    }
    return (
      (u = u || $t(O)),
      (b || x) && ((k = l.clientX + u.x), (T = l.clientY + u.y)),
      (l.pageOffset = u),
      (l.points = [k, T]),
      (l.cursor = b || x),
      l
    );
  }
  function at(l) {
    var u = l - Hr(c, e.ort),
      h = (u * 100) / nt();
    return ((h = _t(h)), e.dir ? 100 - h : h);
  }
  function ei(l) {
    var u = 100,
      h = !1;
    return (
      d.forEach(function (v, b) {
        if (!te(b)) {
          var x = S[b],
            k = Math.abs(x - l),
            T = k === 100 && u === 100,
            B = k < u,
            F = k <= u && l > x;
          (B || F || T) && ((h = b), (u = k));
        }
      }),
      h
    );
  }
  function ti(l, u) {
    l.type === "mouseout" &&
      l.target.nodeName === "HTML" &&
      l.relatedTarget === null &&
      De(l, u);
  }
  function ii(l, u) {
    if (
      navigator.appVersion.indexOf("MSIE 9") === -1 &&
      l.buttons === 0 &&
      u.buttonsProperty !== 0
    )
      return De(l, u);
    var h = (e.dir ? -1 : 1) * (l.calcPoint - u.startCalcPoint),
      v = (h * 100) / u.baseSize;
    lt(h > 0, v, u.locations, u.handleNumbers, u.connect);
  }
  function De(l, u) {
    (u.handle && (Ae(u.handle, e.cssClasses.active), (I -= 1)),
      u.listeners.forEach(function (h) {
        P.removeEventListener(h[0], h[1]);
      }),
      I === 0 &&
        (Ae(o, e.cssClasses.drag),
        He(),
        l.cursor &&
          ((D.style.cursor = ""), D.removeEventListener("selectstart", It))),
      e.events.smoothSteps &&
        (u.handleNumbers.forEach(function (h) {
          pe(h, S[h], !0, !0, !1, !1);
        }),
        u.handleNumbers.forEach(function (h) {
          R("update", h);
        })),
      u.handleNumbers.forEach(function (h) {
        (R("change", h), R("set", h), R("end", h));
      }));
  }
  function Ge(l, u) {
    if (!u.handleNumbers.some(te)) {
      var h;
      if (u.handleNumbers.length === 1) {
        var v = d[u.handleNumbers[0]];
        ((h = v.children[0]), (I += 1), Q(h, e.cssClasses.active));
      }
      l.stopPropagation();
      var b = [],
        x = fe(r.move, P, ii, {
          target: l.target,
          handle: h,
          connect: u.connect,
          listeners: b,
          startCalcPoint: l.calcPoint,
          baseSize: nt(),
          pageOffset: l.pageOffset,
          handleNumbers: u.handleNumbers,
          buttonsProperty: l.buttons,
          locations: S.slice(),
        }),
        k = fe(r.end, P, De, {
          target: l.target,
          handle: h,
          listeners: b,
          doNotReject: !0,
          handleNumbers: u.handleNumbers,
        }),
        T = fe("mouseout", P, ti, {
          target: l.target,
          handle: h,
          listeners: b,
          doNotReject: !0,
          handleNumbers: u.handleNumbers,
        });
      (b.push.apply(b, x.concat(k, T)),
        l.cursor &&
          ((D.style.cursor = getComputedStyle(l.target).cursor),
          d.length > 1 && Q(o, e.cssClasses.drag),
          D.addEventListener("selectstart", It, !1)),
        u.handleNumbers.forEach(function (B) {
          R("start", B);
        }));
    }
  }
  function ri(l) {
    l.stopPropagation();
    var u = at(l.calcPoint),
      h = ei(u);
    h !== !1 &&
      (e.events.snap || Ot(o, e.cssClasses.tap, e.animationDuration),
      pe(h, u, !0, !0),
      He(),
      R("slide", h, !0),
      R("update", h, !0),
      e.events.snap
        ? Ge(l, { handleNumbers: [h] })
        : (R("change", h, !0), R("set", h, !0)));
  }
  function si(l) {
    var u = at(l.calcPoint),
      h = p.getStep(u),
      v = p.fromStepping(h);
    Object.keys(y).forEach(function (b) {
      b.split(".")[0] === "hover" &&
        y[b].forEach(function (x) {
          x.call(Ce, v);
        });
    });
  }
  function ni(l, u) {
    if (ee() || te(u)) return !1;
    var h = ["Left", "Right"],
      v = ["Down", "Up"],
      b = ["PageDown", "PageUp"],
      x = ["Home", "End"];
    e.dir && !e.ort
      ? h.reverse()
      : e.ort && !e.dir && (v.reverse(), b.reverse());
    var k = l.key.replace("Arrow", ""),
      T = k === b[0],
      B = k === b[1],
      F = k === v[0] || k === h[0] || T,
      H = k === v[1] || k === h[1] || B,
      N = k === x[0],
      G = k === x[1];
    if (!F && !H && !N && !G) return !0;
    l.preventDefault();
    var q;
    if (H || F) {
      var K = F ? 0 : 1,
        W = ft(u),
        U = W[K];
      if (U === null) return !1;
      (U === !1 && (U = p.getDefaultStep(S[u], F, e.keyboardDefaultStep)),
        B || T ? (U *= e.keyboardPageMultiplier) : (U *= e.keyboardMultiplier),
        (U = Math.max(U, 1e-7)),
        (U = (F ? -1 : 1) * U),
        (q = w[u] + U));
    } else
      G
        ? (q = e.spectrum.xVal[e.spectrum.xVal.length - 1])
        : (q = e.spectrum.xVal[0]);
    return (
      pe(u, p.toStepping(q), !0, !0),
      R("slide", u),
      R("update", u),
      R("change", u),
      R("set", u),
      !1
    );
  }
  function ot(l) {
    (l.fixed ||
      d.forEach(function (u, h) {
        fe(r.start, u.children[0], Ge, { handleNumbers: [h] });
      }),
      l.tap && fe(r.start, c, ri, {}),
      l.hover && fe(r.move, c, si, { hover: !0 }),
      l.drag &&
        m.forEach(function (u, h) {
          if (!(u === !1 || h === 0 || h === m.length - 1)) {
            var v = d[h - 1],
              b = d[h],
              x = [u],
              k = [v, b],
              T = [h - 1, h];
            (Q(u, e.cssClasses.draggable),
              l.fixed && (x.push(v.children[0]), x.push(b.children[0])),
              l.dragAll && ((k = d), (T = L)),
              x.forEach(function (B) {
                fe(r.start, B, Ge, {
                  handles: k,
                  handleNumbers: T,
                  connect: u,
                });
              }));
          }
        }));
  }
  function Be(l, u) {
    ((y[l] = y[l] || []),
      y[l].push(u),
      l.split(".")[0] === "update" &&
        d.forEach(function (h, v) {
          R("update", v);
        }));
  }
  function ai(l) {
    return l === de.aria || l === de.tooltips;
  }
  function ge(l) {
    var u = l && l.split(".")[0],
      h = u ? l.substring(u.length) : l;
    Object.keys(y).forEach(function (v) {
      var b = v.split(".")[0],
        x = v.substring(b.length);
      (!u || u === b) && (!h || h === x) && (!ai(x) || h === x) && delete y[v];
    });
  }
  function R(l, u, h) {
    Object.keys(y).forEach(function (v) {
      var b = v.split(".")[0];
      l === b &&
        y[v].forEach(function (x) {
          x.call(Ce, w.map(e.format.to), u, w.slice(), h || !1, S.slice(), Ce);
        });
    });
  }
  function Te(l, u, h, v, b, x, k) {
    var T;
    return (
      d.length > 1 &&
        !e.events.unconstrained &&
        (v &&
          u > 0 &&
          ((T = p.getAbsoluteDistance(l[u - 1], e.margin, !1)),
          (h = Math.max(h, T))),
        b &&
          u < d.length - 1 &&
          ((T = p.getAbsoluteDistance(l[u + 1], e.margin, !0)),
          (h = Math.min(h, T)))),
      d.length > 1 &&
        e.limit &&
        (v &&
          u > 0 &&
          ((T = p.getAbsoluteDistance(l[u - 1], e.limit, !1)),
          (h = Math.min(h, T))),
        b &&
          u < d.length - 1 &&
          ((T = p.getAbsoluteDistance(l[u + 1], e.limit, !0)),
          (h = Math.max(h, T)))),
      e.padding &&
        (u === 0 &&
          ((T = p.getAbsoluteDistance(0, e.padding[0], !1)),
          (h = Math.max(h, T))),
        u === d.length - 1 &&
          ((T = p.getAbsoluteDistance(100, e.padding[1], !0)),
          (h = Math.min(h, T)))),
      k || (h = p.getStep(h)),
      (h = _t(h)),
      h === l[u] && !x ? !1 : h
    );
  }
  function Fe(l, u) {
    var h = e.ort;
    return (h ? u : l) + ", " + (h ? l : u);
  }
  function lt(l, u, h, v, b) {
    var x = h.slice(),
      k = v[0],
      T = e.events.smoothSteps,
      B = [!l, l],
      F = [l, !l];
    ((v = v.slice()),
      l && v.reverse(),
      v.length > 1
        ? v.forEach(function (N, G) {
            var q = Te(x, N, x[N] + u, B[G], F[G], !1, T);
            q === !1 ? (u = 0) : ((u = q - x[N]), (x[N] = q));
          })
        : (B = F = [!0]));
    var H = !1;
    (v.forEach(function (N, G) {
      H = pe(N, h[N] + u, B[G], F[G], !1, T) || H;
    }),
      H &&
        (v.forEach(function (N) {
          (R("update", N), R("slide", N));
        }),
        b != null && R("drag", k)));
  }
  function dt(l, u) {
    return e.dir ? 100 - l - u : l;
  }
  function oi(l, u) {
    ((S[l] = u), (w[l] = p.fromStepping(u)));
    var h = dt(u, 0) - z,
      v = "translate(" + Fe(h + "%", "0") + ")";
    if (
      ((d[l].style[e.transformRule] = v),
      e.events.invertConnects && S.length > 1)
    ) {
      var b = S.every(function (x, k, T) {
        return k === 0 || x >= T[k - 1];
      });
      if (E !== !b) {
        pi();
        return;
      }
    }
    (ve(l), ve(l + 1), E && (ve(l - 1), ve(l + 2)));
  }
  function He() {
    L.forEach(function (l) {
      var u = S[l] > 50 ? -1 : 1,
        h = 3 + (d.length + u * l);
      d[l].style.zIndex = String(h);
    });
  }
  function pe(l, u, h, v, b, x) {
    return (
      b || (u = Te(S, l, u, h, v, !1, x)),
      u === !1 ? !1 : (oi(l, u), !0)
    );
  }
  function ve(l) {
    if (m[l]) {
      var u = S.slice();
      E &&
        u.sort(function (T, B) {
          return T - B;
        });
      var h = 0,
        v = 100;
      (l !== 0 && (h = u[l - 1]), l !== m.length - 1 && (v = u[l]));
      var b = v - h,
        x = "translate(" + Fe(dt(h, b) + "%", "0") + ")",
        k = "scale(" + Fe(b / 100, "1") + ")";
      m[l].style[e.transformRule] = x + " " + k;
    }
  }
  function ct(l, u) {
    return l === null ||
      l === !1 ||
      l === void 0 ||
      (typeof l == "number" && (l = String(l)),
      (l = e.format.from(l)),
      l !== !1 && (l = p.toStepping(l)),
      l === !1 || isNaN(l))
      ? S[u]
      : l;
  }
  function Ee(l, u, h) {
    var v = _e(l),
      b = S[0] === void 0;
    ((u = u === void 0 ? !0 : u),
      e.animate && !b && Ot(o, e.cssClasses.tap, e.animationDuration),
      L.forEach(function (T) {
        pe(T, ct(v[T], T), !0, !1, h);
      }));
    var x = L.length === 1 ? 0 : 1;
    if (b && p.hasNoSize() && ((h = !0), (S[0] = 0), L.length > 1)) {
      var k = 100 / (L.length - 1);
      L.forEach(function (T) {
        S[T] = T * k;
      });
    }
    for (; x < L.length; ++x)
      L.forEach(function (T) {
        pe(T, S[T], !0, !0, h);
      });
    (He(),
      L.forEach(function (T) {
        (R("update", T), v[T] !== null && u && R("set", T));
      }));
  }
  function li(l) {
    Ee(e.start, l);
  }
  function di(l, u, h, v) {
    if (((l = Number(l)), !(l >= 0 && l < L.length)))
      throw new Error("noUiSlider: invalid handle number, got: " + l);
    (pe(l, ct(u, l), !0, !0, v), R("update", l), h && R("set", l));
  }
  function ut(l) {
    if ((l === void 0 && (l = !1), l))
      return w.length === 1 ? w[0] : w.slice(0);
    var u = w.map(e.format.to);
    return u.length === 1 ? u[0] : u;
  }
  function ci() {
    for (
      ge(de.aria),
        ge(de.tooltips),
        Object.keys(e.cssClasses).forEach(function (l) {
          Ae(o, e.cssClasses[l]);
        });
      o.firstChild;
    )
      o.removeChild(o.firstChild);
    delete o.noUiSlider;
  }
  function ft(l) {
    var u = S[l],
      h = p.getNearbySteps(u),
      v = w[l],
      b = h.thisStep.step,
      x = null;
    if (e.snap)
      return [
        v - h.stepBefore.startValue || null,
        h.stepAfter.startValue - v || null,
      ];
    (b !== !1 &&
      v + b > h.stepAfter.startValue &&
      (b = h.stepAfter.startValue - v),
      v > h.thisStep.startValue
        ? (x = h.thisStep.step)
        : h.stepBefore.step === !1
          ? (x = !1)
          : (x = v - h.stepBefore.highestStep),
      u === 100 ? (b = null) : u === 0 && (x = null));
    var k = p.countStepDecimals();
    return (
      b !== null && b !== !1 && (b = Number(b.toFixed(k))),
      x !== null && x !== !1 && (x = Number(x.toFixed(k))),
      [x, b]
    );
  }
  function ui() {
    return L.map(ft);
  }
  function fi(l, u) {
    var h = ut(),
      v = [
        "margin",
        "limit",
        "padding",
        "range",
        "animate",
        "snap",
        "step",
        "format",
        "pips",
        "tooltips",
        "connect",
      ];
    v.forEach(function (x) {
      l[x] !== void 0 && (i[x] = l[x]);
    });
    var b = Kt(i);
    (v.forEach(function (x) {
      l[x] !== void 0 && (e[x] = b[x]);
    }),
      (p = b.spectrum),
      (e.margin = b.margin),
      (e.limit = b.limit),
      (e.padding = b.padding),
      e.pips ? ze(e.pips) : Ve(),
      e.tooltips ? j() : _(),
      (S = []),
      Ee(tt(l.start) ? l.start : h, u),
      l.connect && pt());
  }
  function pt() {
    for (; a.firstChild; ) a.removeChild(a.firstChild);
    for (var l = 0; l <= e.handles; l++) ((m[l] = A(a, e.connect[l])), ve(l));
    ot({ drag: e.events.drag, fixed: !0 });
  }
  function pi() {
    ((E = !E),
      Xt(
        e,
        e.connect.map(function (l) {
          return !l;
        }),
      ),
      pt());
  }
  function hi() {
    ((c = V(o)),
      M(e.connect, c),
      ot(e.events),
      Ee(e.start),
      e.pips && ze(e.pips),
      e.tooltips && j(),
      Y());
  }
  hi();
  var Ce = {
    destroy: ci,
    steps: ui,
    on: Be,
    off: ge,
    get: ut,
    set: Ee,
    setHandle: di,
    reset: li,
    disable: xe,
    enable: oe,
    __moveHandles: function (l, u, h) {
      lt(l, u, S, h);
    },
    options: i,
    updateOptions: fi,
    target: o,
    removePips: Ve,
    removeTooltips: _,
    getPositions: function () {
      return S.slice();
    },
    getTooltips: function () {
      return g;
    },
    getOrigins: function () {
      return d;
    },
    pips: ze,
  };
  return Ce;
}
function bs(t, e) {
  if (!t || !t.nodeName)
    throw new Error("noUiSlider: create requires a single element, got: " + t);
  if (t.noUiSlider)
    throw new Error("noUiSlider: Slider was already initialized.");
  var i = Kt(e),
    r = ws(t, i, e);
  return ((t.noUiSlider = r), r);
}
const xs = { __spectrum: Wt, cssClasses: Ut, create: bs };
mi();
const zt = document.querySelector("#menu"),
  Dt = document.querySelector("#menu-button");
zt &&
  Dt &&
  Dt.addEventListener("click", (t) => {
    zt.classList.toggle("header__menu_opened");
  });
const ys = document.querySelectorAll("[data-range]");
ys.forEach((t) => {
  xs.create(t, {
    range: { min: 0, max: 100 },
    start: +t.dataset.range,
    connect: "lower",
  }).on("update", (i) => {
    t.nextElementSibling.textContent = `${(+i[0]).toFixed(0)}%`;
  });
});
